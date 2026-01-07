<?php

namespace App\Http\Controllers\Users\Configs;

use App\Http\Controllers\Controller;
use App\Models\Mosque;
use ArPHP\I18N\Arabic;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use stdClass;
use function App\Http\Controllers\Users\abort;
use function App\Http\Controllers\Users\dd;

class ReminderPrayWA extends Controller
{
    public function index($token)
    {
        $date = new stdClass();
        $mosque = Mosque::wherePlayerToken($token)->first();
        $prayers = $mosque->configPrayers()->where('is_prayer_time', 1);

        $prayers = $prayers->orderBy('order')->get();
        $response = Http::get('https://api.myquran.com/v2/sholat/jadwal/1301/' . date('Y/m/d'));
        if ($response->ok()) {
            $data = json_decode($response->body())->data;
            $data->jadwal->syuruq = $data->jadwal->terbit;
            unset(
                $data->jadwal->tanggal,
                $data->jadwal->date,
                $data->jadwal->dhuha,
                $data->jadwal->terbit);
            $prayerData = (array)$data->jadwal;
        } else {
            echo $response->body();
            abort(500, 'Sorry, There is error in external API.');
        }

        foreach ($prayers as $prayer) {
            $prayers->time = '00:00';
            if ($prayer->name){
                $prayer->time = date('H:i', strtotime($prayerData[$prayer->name]) + ($prayer->time_adjustment * 60));
                $waktuSekarang = Date("H:i");
                //$waktuSekarang = "15:29";
                if($waktuSekarang==$prayer->time){
                    //print("Waktu nya sholat ".$prayer->name);
                    $strWord1 = $this->listOfWord1();
                    $strMsg="ٱلسَّلَامُ عَلَيْكُمْ وَرَحْمَةُ ٱللَّٰهِ وَبَرَكَاتُهُ";
                    $strMsg.="<br><br>بِسْمِ ٱللَّٰهِ ٱلرَّحْمَٰنِ ٱلرَّحِيمِ";
                    $strMsg.="<br><br>".$strWord1;
                    $strMsg.= "<br><br>Waktunya *sholat ".$prayer->name."* (".$prayer->time.") untuk wilayah DKI Jakarta dan sekitarnya";
                    //$strMsg.="<br>Mari kita bersama-sama memenuhi panggilan ini dengan penuh kerendahan hati dan kekhusyukan. ";
                    $strMsg.="<br><br>Mari kita ramaikan ";
                    $strMsg.="<br>*Masjid Jami An-Nur*. ";
                    $strMsg.="<br>Semoga Allah SWT menerima segala amal ibadah kita";
                    $strMsg.="<br><br>آمِيْن يَا رَبَّ العَالَمِيْنَ";

                    $curl = curl_init();
                    $token = "EAWAHHcUJ0nEtXF41K7Gj5HLkNooFBNwddicooCy4kIdKUD5iK9xbSbw8ui6eooH";
                    $random = true;
                    //kirim ke group silaturahmi an nur
                    $payload = [
                        "data" => [
                            [
                                'phone' => '6281318428120-1496916179',
                                'message' => $strMsg,
                                'isGroup' => true
                            ],
                        ]
                    ];

                    curl_setopt($curl, CURLOPT_HTTPHEADER,
                        array(
                            "Authorization: $token",
                            "Content-Type: application/json"
                        )
                    );
                    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
                    curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
                    curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($payload) );
                    curl_setopt($curl, CURLOPT_URL,  "https://jogja.wablas.com/api/v2/send-message");
                    curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
                    curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);

                    $result = curl_exec($curl);
                    curl_close($curl);
                    echo "<pre>";
                    print_r($result);
                }
            }
        }

    }
    private function listOfWord1()
    {
        $arrWords = [
            0 => "Waktunya sholat telah tiba. Mari kita tinggalkan sejenak urusan dunia dan bersujud kepada-Nya. 🤲",
            1 => "Jangan lupa sholat, sahabatku. Itu momen kita untuk berkomunikasi langsung dengan Pencipta. 🌿",
            2 => "Sholat adalah istirahat untuk jiwa. Mari kita perbarui energi spiritual kita. ⏳",
            3 => "Ingat, sholat itu tiang agama. Ayo, jangan sampai kita lalai. 🕌",
            4 => "Saatnya sholat. Mari kita bersihkan hati dan pikiran kita dengan sujud kepada Allah. 💖",
            5 => "Sholatlah dengan khusyuk, karena di dalamnya terdapat kunci kedamaian hati. 🗝️",
            6 => "Mari kita sambut waktu sholat dengan semangat untuk mendekatkan diri kepada Allah. 🌼",
            7 => "Jangan biarkan kesibukan membuat kita lupa akan waktu sholat. Itu saatnya kita untuk beristirahat di sisi-Nya. 🕰️",
            8 => "Setiap waktu sholat adalah kesempatan untuk bersihkan diri dari dosa. Ayo, manfaatkan! 🌱",
            9 => "Sholat bukan hanya kewajiban, tapi juga kebutuhan jiwa. Mari kita penuhi dengan penuh cinta. 💓",
            10 => "Saat adzan berkumandang, itu panggilan cinta dari Allah. Mari kita respons dengan sholat. 📣",
            11 => "Mari kita jadikan sholat sebagai prioritas, bukan opsi. Itu adalah panggilan suci kita. 🛐",
            12 => "Sholat adalah cara kita untuk mengucap syukur atas segala nikmat yang telah diberikan Allah. 🙏",
            13 => "Ingatlah, melalui sholat, kita mendekatkan diri kepada Allah dan menjauhkan diri dari syaitan. 🔥",
            14 => "Sholat adalah pelukan hangat dari Allah, mengingatkan kita bahwa kita tidak pernah sendirian. 🤗",
            15 => "Jangan tunda sholat. Setiap detik dalam ibadah adalah berharga. ⌛",
            16 => "Mari kita isi hari kita dengan sholat yang khusyuk, sebagai bukti cinta kita kepada Allah. 💞",
            17 => "Sholat adalah dialog pribadi kita dengan Allah. Mari kita buat setiap kata dan gerakan berarti. 🌺",
            18 => "Setiap sujud dalam sholat adalah kesempatan untuk lebih dekat dengan Allah. Jangan sia-siakan. 🍃",
            19 => "Mari kita akhiri dan mulai hari dengan sholat, mengingatkan diri bahwa Allah selalu bersama kita. 🌙🌞",
            20 => "Saudara-saudariku yang aku cintai dalam iman, mari kita renungkan sejenak. Di tengah kehidupan yang serba cepat dan penuh tantangan ini, seringkali kita merasa lelah, baik secara fisik maupun emosi. Namun, ingatlah bahwa Allah SWT telah memberikan kita waktu sholat sebagai oasis di tengah padang pasir kehidupan. Sholat adalah saat di mana kita dapat menarik nafas, beristirahat sejenak dari kejaran dunia, dan mengisi ulang energi spiritual kita. Dalam setiap gerakan dan doa, ada kesempatan untuk melepaskan segala kepenatan dan memperbaharui kekuatan. Jadi, mari kita sambut setiap waktu sholat dengan hati yang terbuka dan jiwa yang siap menerima kedamaian dari-Nya.",
            21 => "Telah tiba saatnya bagi kita untuk meninggalkan kesibukan dunia sejenak dan beralih kepada panggilan Ilahi.",
            22 => "Saatnya telah tiba, untuk kita kembali kepada-Nya. Ingatlah, sholat adalah tiang agama, jangan sampai kita lalai. Ayo, kita siapkan diri, bersuci dan berwudhu, lalu berdiri khusyuk di hadapan Rabbul Izzati. Semoga kita semua diberikan kekuatan dan konsistensi dalam menjalankan sholat 5 waktu",
            23 => "Saudaraku yang dirahmati Allah, ingatlah bahwa sholat bukan sekedar rutinitas, tapi dialog antara hamba dan Penciptanya. Mari kita hadirkan hati dan jiwa kita dalam setiap gerakan dan doa, menjadikan setiap detik berharga di hadapan-Nya.",
            24 => "Sudah waktunya kita menyegarkan iman dan membersihkan hati dengan sholat. Mari kita berdiri menghadap kiblat, memperbaharui niat untuk beribadah kepada-Nya.",
            25 => "Saudara-saudariku yang tercinta, Mari kita ingat bahwa sholat adalah jembatan yang menghubungkan jiwa kita dengan Sang Pencipta. Dalam kesibukan dan kecepatan hidup, sholat adalah panggilan untuk berhenti sejenak, merenung, dan bersyukur atas segala nikmat yang telah diberikan kepada kita. Sholat bukan hanya ritual, tapi juga obat bagi hati yang gundah dan pikiran yang kacau. Ayo, kita jadikan setiap sholat sebagai momen untuk kembali ke jalan yang benar, menguatkan iman dan memperbaharui komitmen kita kepada Allah SWT.",
            26 => "Saudara-saudariku yang aku hormati, Dalam hiruk pikuk dunia yang penuh dengan ujian dan godaan, sholat adalah penenang jiwa, penjernih pikiran, dan penguat hati. Ia adalah waktu di mana kita dapat mengadu, meminta, dan berterima kasih kepada Allah atas segala hal dalam hidup kita. Sholat mengingatkan kita bahwa kita tidak sendirian, bahwa Allah selalu mendengar dan mengetahui. Jadi, mari kita perkuat hubungan kita dengan-Nya melalui sholat, menjadikannya sebagai sumber kekuatan dan inspirasi dalam menjalani kehidupan.",
            27 => "Sahabat-sahabatku yang baik, ingatkah kita bahwa sholat adalah kunci kebahagiaan dan ketenangan? Dalam setiap ruku' dan sujud, ada kesempatan untuk melepaskan beban dunia dari bahu kita dan menyerahkannya kepada Allah. Sholat adalah saat kita mengakui kelemahan dan kebutuhan kita akan bimbingan-Nya. Dengan sholat, kita membangun fondasi yang kuat untuk iman kita, mengisi ulang energi spiritual kita, dan menemukan kedamaian dalam kekacauan dunia. Jadi, mari kita tidak melewatkan sholat kita, karena dalam setiap sholat, ada kesempatan untuk menjadi lebih baik.",
            28 => "Saudaraku yang dirahmati Allah, Setiap kali adzan berkumandang, itu adalah panggilan cinta dari Allah, mengajak kita untuk kembali kepada-Nya, meninggalkan sementara urusan dunia. Sholat adalah kesempatan emas untuk membersihkan jiwa, memperkuat iman, dan memohon petunjuk dalam setiap langkah hidup kita. Dalam sujud terdapat kekuatan, dalam doa terdapat harapan, dan dalam setiap sholat terdapat kesempatan untuk memperbaiki diri. Jangan biarkan kesibukan membuat kita lupa akan panggilan suci ini. Ayo, kita isi hari-hari kita dengan sholat yang khusyuk, sebagai bukti cinta dan taqwa kita kepada Allah SWT.",
            29 => "Sahabat-sahabatku yang mulia, di setiap hari, Allah SWT memberikan kita lima kesempatan emas melalui sholat untuk bertemu dan berkomunikasi dengan-Nya. Ini adalah momen-momen spesial dimana kita dapat menyampaikan rasa syukur, harapan, kekhawatiran, dan bahkan ketakutan kita langsung kepada-Nya. Sholat adalah pengingat bahwa tidak peduli seberapa sibuk atau beratnya hidup, kita selalu memiliki tempat untuk kembali dan bersandar. Ini adalah pelukan hangat dari Allah, mengingatkan kita bahwa kita tidak pernah sendirian. Jadi, mari kita hargai dan manfaatkan kesempatan ini dengan sebaik-baiknya.",
            30 => "Saudaraku yang terkasih, Sholat bukan hanya tentang berdiri, ruku, dan sujud. Lebih dari itu, sholat adalah perjalanan jiwa menuju ketenangan, kejernihan pikiran, dan kedekatan dengan Allah SWT. Setiap kali kita melafazkan takbir, itu adalah pengumuman bahwa Allah lebih besar dari segala masalah dan kekhawatiran kita. Dalam setiap sujud, kita meletakkan dahi di bumi, mengingatkan diri bahwa kebesaran hanya milik Allah. Sholat adalah dialog hati kita dengan Pencipta, dimana kita bisa memohon, berterima kasih, dan memperbaharui janji kita untuk hidup sesuai dengan tuntunan-Nya. Jadi, mari kita jadikan sholat sebagai prioritas, bukan hanya sebagai kegiatan sampingan dalam rutinitas harian kita.",

        ];

        return $this->getRandomElementFromArray($arrWords);
    }

    private function getRandomElementFromArray($array) {
        if (!is_array($array) || empty($array)) {
            return null; // Return null jika array kosong atau bukan array
        }

        $randomKey = array_rand($array); // Mendapatkan kunci acak dari array
        return $array[$randomKey]; // Mengembalikan nilai berdasarkan kunci acak
    }

}
