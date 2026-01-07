<?php

namespace App\Http\Controllers\Users;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class FileController extends Controller
{
    public function create()
    {
        return view('users.files.create');
    }

    public function index()
    {
        $mosqueId = Auth::user()->mosque->id;

        // Get active files only (not archived)
        $backgrounds = DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('type', 'background')
            ->where('status', '!=', 'archived')
            ->orderBy('created_at', 'desc')
            ->get();

        $images = DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('type', 'image')
            ->where('status', '!=', 'archived')
            ->orderBy('created_at', 'desc')
            ->get();

        $videos = DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('type', 'video')
            ->where('status', '!=', 'archived')
            ->orderBy('created_at', 'desc')
            ->get();

        // Get archived files
        $archived = DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('status', 'archived')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('users.files.index', [
            'backgrounds' => $backgrounds,
            'images' => $images,
            'videos' => $videos,
            'archived' => $archived,
        ]);
    }

    public function show($id)
    {
        $data = DB::table('files')->where('id', $id)->first();

        if (!$data) {
            abort(404, 'File not found');
        }

        // Check if user owns this file
        if ($data->mosque_id !== Auth::user()->mosque->id) {
            abort(403, 'Unauthorized access');
        }

        return view('users.files.show', [
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        if (!$request->file('file'))
            return redirect()->back()->with('error', 'File tidak valid.');

        $data = $request->validate([
            'file' => 'required|file|max:102400', // Max 100MB
            'is_template' => 'required|boolean',
            'type' => 'required|string|in:background,image,video',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        // Additional validation based on file type
        $file = $request->file('file');
        $mimeType = $file->getMimeType();

        if ($data['type'] === 'video') {
            $request->validate([
                'file' => 'mimes:mp4,avi,mov,wmv,flv,webm|max:102400' // Max 100MB for video
            ]);
        } else {
            $request->validate([
                'file' => 'mimes:png,jpg,gif,jpeg,webp,svg|max:10240' // Max 10MB for images
            ]);
        }

        $mosque = DB::table('mosques')->where('id', Auth::user()->mosque->id)->first();

        try {
            DB::beginTransaction();

            // Prepare file data
            $data['path'] = $mosque->storage_path .'/'. $data['type'] .'/';
            $data['name'] = Str::random(8) .'_'. date('Ymd') .'.'. $file->extension();
            $data['mimetype'] = $mimeType;

            // Set status based on dates
            $now = Carbon::now();
            $startDate = Carbon::parse($data['start_date']);
            $endDate = Carbon::parse($data['end_date']);

            if ($startDate <= $now && $endDate > $now) {
                $data['status'] = '1'; // Active
            } elseif ($startDate > $now) {
                $data['status'] = '2'; // Scheduled
            } else {
                $data['status'] = '0'; // Expired
            }

            // Store file
            Storage::disk('public')->putFileAs($data['path'], $file, $data['name']);

            // Create database record
            DB::table('files')->insert([
                'mosque_id' => $mosque->id,
                'type' => $data['type'],
                'name' => $data['name'],
                'path' => $data['path'],
                'mimetype' => $data['mimetype'],
                'is_template' => $data['is_template'],
                'start_date' => $data['start_date'],
                'end_date' => $data['end_date'],
                'status' => $data['status'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            DB::commit();

            // Trigger refresh for display
            $this->triggerDisplayRefresh($mosque->player_token);

            return redirect()->back()->with('success', 'Berhasil menyimpan file.');

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('File upload failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menyimpan file: ' . $e->getMessage());
        }
    }

    public function destroy($id)
    {
        try {
            $file = DB::table('files')->where('id', $id)->first();

            if (!$file) {
                return redirect()->back()->with('error', 'File not found.');
            }

            // Check ownership
            if ($file->mosque_id !== Auth::user()->mosque->id) {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }

            // Delete physical file
            Storage::disk('public')->delete($file->path . $file->name);

            // Delete database record
            DB::table('files')->where('id', $id)->delete();

            // Trigger refresh
            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return redirect()->back()->with('success', 'Berhasil menghapus file.');

        } catch (\Exception $e) {
            Log::error('File deletion failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus file.');
        }
    }

    // ========================================
    // SCHEDULE MANAGEMENT METHODS
    // ========================================

    public function updateSchedule(Request $request, $id)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        try {
            $file = DB::table('files')->where('id', $id)->first();

            if (!$file) {
                return redirect()->back()->with('error', 'File not found.');
            }

            // Check ownership
            if ($file->mosque_id !== Auth::user()->mosque->id) {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }

            DB::table('files')
                ->where('id', $id)
                ->update([
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'status' => $this->calculateStatus($request->start_date, $request->end_date),
                    'updated_at' => now()
                ]);

            // Trigger refresh
            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return redirect()->back()->with('success', 'Jadwal berhasil diperbarui.');

        } catch (\Exception $e) {
            Log::error('Schedule update failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memperbarui jadwal.');
        }
    }

    public function getSchedule($id)
    {
        try {
            $file = DB::table('files')->where('id', $id)->first();

            if (!$file) {
                return response()->json(['error' => 'File not found'], 404);
            }

            // Check ownership
            if ($file->mosque_id !== Auth::user()->mosque->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            return response()->json([
                'success' => true,
                'data' => [
                    'start_date' => $file->start_date ? Carbon::parse($file->start_date)->format('Y-m-d\TH:i') : null,
                    'end_date' => $file->end_date ? Carbon::parse($file->end_date)->format('Y-m-d\TH:i') : null,
                    'status' => $file->status
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Get schedule failed: ' . $e->getMessage());
            return response()->json(['error' => 'File not found'], 404);
        }
    }

    // ========================================
    // ARCHIVE MANAGEMENT METHODS
    // ========================================

    public function archive($id)
    {
        try {
            $file = DB::table('files')->where('id', $id)->first();

            if (!$file) {
                return redirect()->back()->with('error', 'File not found.');
            }

            // Check ownership
            if ($file->mosque_id !== Auth::user()->mosque->id) {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }

            DB::table('files')
                ->where('id', $id)
                ->update([
                    'status' => 'archived',
                    'updated_at' => now()
                ]);

            // Trigger refresh
            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return redirect()->back()->with('success', 'File berhasil diarsipkan.');

        } catch (\Exception $e) {
            Log::error('Archive failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengarsipkan file.');
        }
    }

    public function restore($id)
    {
        try {
            $file = DB::table('files')->where('id', $id)->first();

            if (!$file) {
                return redirect()->back()->with('error', 'File not found.');
            }

            // Check ownership
            if ($file->mosque_id !== Auth::user()->mosque->id) {
                return redirect()->back()->with('error', 'Unauthorized access.');
            }

            // Calculate new status based on current dates
            $status = $this->calculateStatus($file->start_date, $file->end_date);

            DB::table('files')
                ->where('id', $id)
                ->update([
                    'status' => $status,
                    'updated_at' => now()
                ]);

            // Trigger refresh
            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return redirect()->back()->with('success', 'File berhasil dipulihkan.');

        } catch (\Exception $e) {
            Log::error('Restore failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memulihkan file.');
        }
    }

    // ========================================
    // STATUS MANAGEMENT METHODS
    // ========================================

    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:0,1,2,archived'
        ]);

        try {
            $file = DB::table('files')->where('id', $id)->first();

            if (!$file) {
                return response()->json(['error' => 'File not found'], 404);
            }

            // Check ownership
            if ($file->mosque_id !== Auth::user()->mosque->id) {
                return response()->json(['error' => 'Unauthorized'], 403);
            }

            DB::table('files')
                ->where('id', $id)
                ->update([
                    'status' => $request->status,
                    'updated_at' => now()
                ]);

            // Trigger refresh
            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return response()->json(['success' => true, 'message' => 'Status berhasil diperbarui.']);

        } catch (\Exception $e) {
            Log::error('Status update failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memperbarui status.'], 500);
        }
    }

    public function checkStatuses()
    {
        try {
            $mosqueId = Auth::user()->mosque->id;
            $this->updateFileStatuses($mosqueId);

            return response()->json(['success' => true, 'message' => 'Status files updated.']);

        } catch (\Exception $e) {
            Log::error('Status check failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memeriksa status.'], 500);
        }
    }

    // ========================================
    // BULK OPERATIONS METHODS
    // ========================================

    public function bulkArchive(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:files,id'
        ]);

        try {
            $mosqueId = Auth::user()->mosque->id;

            DB::table('files')
                ->whereIn('id', $request->ids)
                ->where('mosque_id', $mosqueId)
                ->update([
                    'status' => 'archived',
                    'updated_at' => now()
                ]);

            // Trigger refresh
            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return redirect()->back()->with('success', 'Files berhasil diarsipkan.');

        } catch (\Exception $e) {
            Log::error('Bulk archive failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengarsipkan files.');
        }
    }

    public function bulkRestore(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:files,id'
        ]);

        try {
            $mosqueId = Auth::user()->mosque->id;

            $files = DB::table('files')
                ->whereIn('id', $request->ids)
                ->where('mosque_id', $mosqueId)
                ->get();

            foreach ($files as $file) {
                $status = $this->calculateStatus($file->start_date, $file->end_date);
                DB::table('files')
                    ->where('id', $file->id)
                    ->update([
                        'status' => $status,
                        'updated_at' => now()
                    ]);
            }

            // Trigger refresh
            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return redirect()->back()->with('success', 'Files berhasil dipulihkan.');

        } catch (\Exception $e) {
            Log::error('Bulk restore failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal memulihkan files.');
        }
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids' => 'required|array',
            'ids.*' => 'integer|exists:files,id'
        ]);

        try {
            $mosqueId = Auth::user()->mosque->id;

            $files = DB::table('files')
                ->whereIn('id', $request->ids)
                ->where('mosque_id', $mosqueId)
                ->get();

            foreach ($files as $file) {
                // Delete physical file
                Storage::disk('public')->delete($file->path . $file->name);
                DB::table('files')->where('id', $file->id)->delete();
            }

            // Trigger refresh
            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return redirect()->back()->with('success', 'Files berhasil dihapus.');

        } catch (\Exception $e) {
            Log::error('Bulk delete failed: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal menghapus files.');
        }
    }

    // ========================================
    // FILTER METHODS
    // ========================================

    public function archived()
    {
        $mosqueId = Auth::user()->mosque->id;

        $archived = DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('status', 'archived')
            ->orderBy('updated_at', 'desc')
            ->get();

        return view('users.files.archived', ['files' => $archived]);
    }

    public function active()
    {
        $mosqueId = Auth::user()->mosque->id;

        $active = DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('status', '1')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('users.files.active', ['files' => $active]);
    }

    public function scheduled()
    {
        $mosqueId = Auth::user()->mosque->id;

        $scheduled = DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('status', '2')
            ->orderBy('start_date', 'asc')
            ->get();

        return view('users.files.scheduled', ['files' => $scheduled]);
    }

    public function expired()
    {
        $mosqueId = Auth::user()->mosque->id;

        $expired = DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('status', '0')
            ->orderBy('end_date', 'desc')
            ->get();

        return view('users.files.expired', ['files' => $expired]);
    }

    // ========================================
    // API METHODS FOR AJAX (IMPROVED VERSION)
    // ========================================

    public function apiUpdateSchedule(Request $request)
    {
        // Enhanced logging and error handling
        Log::info('API Update Schedule Called', [
            'request_data' => $request->all(),
            'user_id' => Auth::id(),
            'method' => $request->method(),
            'url' => $request->fullUrl()
        ]);

        try {
            // Step 1: Validation
            $request->validate([
                'id' => 'required|integer|exists:files,id',
                'start_date' => 'required|date',
                'end_date' => 'required|date|after:start_date',
            ]);

            // Step 2: Get file and check ownership
            $file = DB::table('files')->where('id', $request->id)->first();

            if (!$file) {
                return response()->json(['error' => 'File not found'], 404);
            }

            // Enhanced ownership check with better error handling
            $user = Auth::user();
            if (!$user || !$user->mosque) {
                return response()->json(['error' => 'User has no mosque associated'], 403);
            }

            if ((int)$file->mosque_id !== (int)$user->mosque->id) {
                Log::warning('Ownership check failed', [
                    'file_mosque_id' => $file->mosque_id,
                    'user_mosque_id' => $user->mosque->id,
                    'file_id' => $request->id,
                    'user_id' => $user->id
                ]);
                return response()->json(['error' => 'Unauthorized - File belongs to different mosque'], 403);
            }

            // Step 3: Calculate new status
            $newStatus = $this->calculateStatus($request->start_date, $request->end_date);

            // Step 4: Update database
            $updated = DB::table('files')
                ->where('id', $request->id)
                ->update([
                    'start_date' => $request->start_date,
                    'end_date' => $request->end_date,
                    'status' => $newStatus,
                    'updated_at' => now()
                ]);

            if ($updated) {
                // Step 5: Trigger display refresh
                $this->triggerDisplayRefresh($user->mosque->player_token);

                Log::info('Schedule updated successfully', [
                    'file_id' => $request->id,
                    'new_status' => $newStatus
                ]);

                return response()->json([
                    'success' => true,
                    'message' => 'Jadwal berhasil diperbarui.',
                    'data' => [
                        'file_id' => $request->id,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'new_status' => $newStatus,
                        'updated_at' => now()->toISOString()
                    ]
                ]);
            } else {
                return response()->json(['error' => 'No rows were updated'], 500);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('Validation failed in API Update Schedule', [
                'errors' => $e->errors(),
                'input' => $request->all()
            ]);
            return response()->json([
                'error' => 'Validation failed',
                'details' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            Log::error('General Error in API Update Schedule', [
                'error_message' => $e->getMessage(),
                'error_file' => $e->getFile(),
                'error_line' => $e->getLine(),
                'request_data' => $request->all(),
                'user_id' => Auth::id()
            ]);

            return response()->json([
                'error' => 'Gagal memperbarui jadwal',
                'details' => $e->getMessage()
            ], 500);
        }
    }

    public function apiArchive(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:files,id'
        ]);

        try {
            $file = DB::table('files')->where('id', $request->id)->first();

            if (!$file || (int)$file->mosque_id !== (int)Auth::user()->mosque->id) {
                return response()->json(['error' => 'File not found or unauthorized'], 404);
            }

            DB::table('files')
                ->where('id', $request->id)
                ->update([
                    'status' => 'archived',
                    'updated_at' => now()
                ]);

            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return response()->json(['success' => true, 'message' => 'File berhasil diarsipkan.']);

        } catch (\Exception $e) {
            Log::error('API archive failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengarsipkan file.'], 500);
        }
    }

    public function apiRestore(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:files,id'
        ]);

        try {
            $file = DB::table('files')->where('id', $request->id)->first();

            if (!$file || (int)$file->mosque_id !== (int)Auth::user()->mosque->id) {
                return response()->json(['error' => 'File not found or unauthorized'], 404);
            }

            $status = $this->calculateStatus($file->start_date, $file->end_date);

            DB::table('files')
                ->where('id', $request->id)
                ->update([
                    'status' => $status,
                    'updated_at' => now()
                ]);

            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return response()->json(['success' => true, 'message' => 'File berhasil dipulihkan.']);

        } catch (\Exception $e) {
            Log::error('API restore failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal memulihkan file.'], 500);
        }
    }

    public function apiDelete(Request $request)
    {
        $request->validate([
            'id' => 'required|integer|exists:files,id'
        ]);

        try {
            $file = DB::table('files')->where('id', $request->id)->first();

            if (!$file || (int)$file->mosque_id !== (int)Auth::user()->mosque->id) {
                return response()->json(['error' => 'File not found or unauthorized'], 404);
            }

            // Delete physical file
            Storage::disk('public')->delete($file->path . $file->name);
            DB::table('files')->where('id', $request->id)->delete();

            $this->triggerDisplayRefresh(Auth::user()->mosque->player_token);

            return response()->json(['success' => true, 'message' => 'File berhasil dihapus.']);

        } catch (\Exception $e) {
            Log::error('API delete failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal menghapus file.'], 500);
        }
    }

    public function apiList(Request $request)
    {
        try {
            $mosqueId = Auth::user()->mosque->id;
            $query = DB::table('files')->where('mosque_id', $mosqueId);

            // Apply filters
            if ($request->type) {
                $query->where('type', $request->type);
            }

            if ($request->status) {
                $query->where('status', $request->status);
            }

            $files = $query->orderBy('created_at', 'desc')->get();

            return response()->json(['success' => true, 'data' => $files]);

        } catch (\Exception $e) {
            Log::error('API list failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil data.'], 500);
        }
    }

    public function apiStats()
    {
        try {
            $mosqueId = Auth::user()->mosque->id;

            $stats = [
                'total' => DB::table('files')->where('mosque_id', $mosqueId)->count(),
                'active' => DB::table('files')->where('mosque_id', $mosqueId)->where('status', '1')->count(),
                'scheduled' => DB::table('files')->where('mosque_id', $mosqueId)->where('status', '2')->count(),
                'expired' => DB::table('files')->where('mosque_id', $mosqueId)->where('status', '0')->count(),
                'archived' => DB::table('files')->where('mosque_id', $mosqueId)->where('status', 'archived')->count(),
                'by_type' => [
                    'background' => DB::table('files')->where('mosque_id', $mosqueId)->where('type', 'background')->count(),
                    'image' => DB::table('files')->where('mosque_id', $mosqueId)->where('type', 'image')->count(),
                    'video' => DB::table('files')->where('mosque_id', $mosqueId)->where('type', 'video')->count(),
                ]
            ];

            return response()->json(['success' => true, 'data' => $stats]);

        } catch (\Exception $e) {
            Log::error('API stats failed: ' . $e->getMessage());
            return response()->json(['error' => 'Gagal mengambil statistik.'], 500);
        }
    }

    // Bulk operations APIs
    public function apiBulkArchive(Request $request)
    {
        return $this->bulkArchive($request);
    }

    public function apiBulkRestore(Request $request)
    {
        return $this->bulkRestore($request);
    }

    public function apiBulkDelete(Request $request)
    {
        return $this->bulkDelete($request);
    }

    // ========================================
    // CRON JOB METHODS
    // ========================================

    public function cronUpdateStatuses()
    {
        try {
            $mosques = DB::table('mosques')->pluck('id');

            foreach ($mosques as $mosqueId) {
                $this->updateFileStatuses($mosqueId);
            }

            Log::info('File statuses updated successfully');
            return response()->json(['success' => true, 'message' => 'All file statuses updated.']);

        } catch (\Exception $e) {
            Log::error('Cron status update failed: ' . $e->getMessage());
            return response()->json(['error' => 'Cron job failed.'], 500);
        }
    }

    public function cronAutoArchive()
    {
        try {
            $expiredCount = DB::table('files')
                ->where('status', '0')
                ->where('end_date', '<', Carbon::now()->subDays(7))
                ->update(['status' => 'archived', 'updated_at' => now()]);

            Log::info("Auto-archived {$expiredCount} expired files");
            return response()->json(['success' => true, 'message' => "Auto-archived {$expiredCount} files."]);

        } catch (\Exception $e) {
            Log::error('Cron auto archive failed: ' . $e->getMessage());
            return response()->json(['error' => 'Auto archive failed.'], 500);
        }
    }

    public function cronCleanupArchives()
    {
        try {
            // Get archived files older than 30 days
            $oldArchives = DB::table('files')
                ->where('status', 'archived')
                ->where('updated_at', '<', Carbon::now()->subDays(30))
                ->get();

            $count = 0;
            foreach ($oldArchives as $file) {
                Storage::disk('public')->delete($file->path . $file->name);
                DB::table('files')->where('id', $file->id)->delete();
                $count++;
            }

            Log::info("Cleaned up {$count} old archived files");
            return response()->json(['success' => true, 'message' => "Cleaned up {$count} files."]);

        } catch (\Exception $e) {
            Log::error('Cron cleanup failed: ' . $e->getMessage());
            return response()->json(['error' => 'Cleanup failed.'], 500);
        }
    }

    // ========================================
    // DISPLAY/PLAYER METHODS
    // ========================================

    public function getActiveMedia($token)
    {
        try {
            $mosque = DB::table('mosques')->where('player_token', $token)->first();

            if (!$mosque) {
                return response()->json(['error' => 'Invalid token'], 404);
            }

            $this->updateFileStatuses($mosque->id);

            $media = [
                'backgrounds' => DB::table('files')
                    ->where('mosque_id', $mosque->id)
                    ->where('type', 'background')
                    ->where('status', '1')
                    ->get(),
                'images' => DB::table('files')
                    ->where('mosque_id', $mosque->id)
                    ->where('type', 'image')
                    ->where('status', '1')
                    ->get(),
                'videos' => DB::table('files')
                    ->where('mosque_id', $mosque->id)
                    ->where('type', 'video')
                    ->where('status', '1')
                    ->get(),
            ];

            return response()->json(['success' => true, 'data' => $media]);

        } catch (\Exception $e) {
            Log::error('Get active media failed: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to get media.'], 500);
        }
    }

    public function getCurrentBackground($token)
    {
        try {
            $mosque = DB::table('mosques')->where('player_token', $token)->first();

            if (!$mosque) {
                return response()->json(['error' => 'Invalid token'], 404);
            }

            $background = DB::table('files')
                ->where('mosque_id', $mosque->id)
                ->where('type', 'background')
                ->where('status', '1')
                ->orderBy('created_at', 'desc')
                ->first();

            return response()->json(['success' => true, 'data' => $background]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get background.'], 500);
        }
    }

    public function getCurrentImages($token)
    {
        try {
            $mosque = DB::table('mosques')->where('player_token', $token)->first();

            if (!$mosque) {
                return response()->json(['error' => 'Invalid token'], 404);
            }

            $images = DB::table('files')
                ->where('mosque_id', $mosque->id)
                ->where('type', 'image')
                ->where('status', '1')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['success' => true, 'data' => $images]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get images.'], 500);
        }
    }

    public function getCurrentVideos($token)
    {
        try {
            $mosque = DB::table('mosques')->where('player_token', $token)->first();

            if (!$mosque) {
                return response()->json(['error' => 'Invalid token'], 404);
            }

            $videos = DB::table('files')
                ->where('mosque_id', $mosque->id)
                ->where('type', 'video')
                ->where('status', '1')
                ->orderBy('created_at', 'desc')
                ->get();

            return response()->json(['success' => true, 'data' => $videos]);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to get videos.'], 500);
        }
    }

    // ========================================
    // HELPER METHODS
    // ========================================

    private function calculateStatus($startDate, $endDate)
    {
        try {
            $now = Carbon::now();
            $start = Carbon::parse($startDate);
            $end = Carbon::parse($endDate);

            if ($start <= $now && $end > $now) {
                return '1'; // Active
            } elseif ($start > $now) {
                return '2'; // Scheduled
            } else {
                return '0'; // Expired
            }

        } catch (\Exception $e) {
            Log::error('Error in calculateStatus', [
                'error' => $e->getMessage(),
                'start_date' => $startDate,
                'end_date' => $endDate
            ]);
            return '0'; // Default to expired on error
        }
    }

    private function updateFileStatuses($mosqueId)
    {
        $now = Carbon::now();

        // Update expired files
        DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('end_date', '<', $now)
            ->whereIn('status', ['1', '2'])
            ->update(['status' => '0', 'updated_at' => now()]);

        // Update scheduled files that should be active
        DB::table('files')
            ->where('mosque_id', $mosqueId)
            ->where('start_date', '<=', $now)
            ->where('end_date', '>', $now)
            ->where('status', '2')
            ->update(['status' => '1', 'updated_at' => now()]);
    }

    private function triggerDisplayRefresh($playerToken)
    {
        try {
            if (!$playerToken) {
                Log::warning('No player token provided for refresh');
                return;
            }

            // Get base URL dynamically based on current request
            $baseUrl = request()->getSchemeAndHttpHost();
            $url = "{$baseUrl}/refresh-status?player_token={$playerToken}&vIsRefresh=true";

            Log::info('Sending refresh request to', ['url' => $url]);

            $curl = curl_init();

            curl_setopt_array($curl, [
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 10,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "GET",
                CURLOPT_HTTPHEADER => [
                    "authorization: Bearer your-access-token",
                    "content-type: application/json",
                ],
            ]);

            $response = curl_exec($curl);
            $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
            $err = curl_error($curl);

            curl_close($curl);

            if ($err) {
                Log::warning('Display refresh cURL error', [
                    'error' => $err,
                    'url' => $url
                ]);
            } else {
                Log::info('Display refresh response', [
                    'http_code' => $httpCode,
                    'response' => $response,
                    'url' => $url
                ]);
            }

        } catch (\Exception $e) {
            Log::error('Display refresh error', [
                'error' => $e->getMessage(),
                'player_token' => $playerToken
            ]);
        }
    }

    // Additional utility methods for debugging and admin
    public function debugOwnership(Request $request)
    {
        try {
            $fileId = $request->get('file_id');
            $user = Auth::user();

            // Get file info
            $file = DB::table('files')->where('id', $fileId)->first();

            // Get user mosque info
            $userMosque = $user->mosque;

            // Get all files for this user's mosque
            $userFiles = DB::table('files')
                ->where('mosque_id', $userMosque ? $userMosque->id : null)
                ->get(['id', 'name', 'type', 'mosque_id']);

            return response()->json([
                'debug_info' => [
                    'user' => [
                        'id' => $user->id,
                        'email' => $user->email,
                        'mosque_id_from_user_table' => $user->mosque_id ?? 'null'
                    ],
                    'user_mosque' => $userMosque ? [
                        'id' => $userMosque->id,
                        'name' => $userMosque->name,
                        'id_type' => gettype($userMosque->id)
                    ] : 'null',
                    'requested_file' => $file ? [
                        'id' => $file->id,
                        'name' => $file->name,
                        'mosque_id' => $file->mosque_id,
                        'mosque_id_type' => gettype($file->mosque_id)
                    ] : 'null',
                    'user_files_count' => $userFiles->count(),
                    'ownership_check' => [
                        'file_mosque_id' => $file ? $file->mosque_id : null,
                        'user_mosque_id' => $userMosque ? $userMosque->id : null,
                        'strict_match' => $file && $userMosque ? ($file->mosque_id === $userMosque->id) : false,
                        'loose_match' => $file && $userMosque ? ($file->mosque_id == $userMosque->id) : false,
                        'int_comparison' => $file && $userMosque ? ((int)$file->mosque_id === (int)$userMosque->id) : false
                    ]
                ]
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Debug failed',
                'message' => $e->getMessage(),
                'line' => $e->getLine()
            ]);
        }
    }

    // Legacy method for compatibility
    public function updateBGStart($id)
    {
        return $this->destroy($id);
    }
}
