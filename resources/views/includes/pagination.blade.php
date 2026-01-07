<div class="d-flex justify-content-center mt-3">
    <ul class="pagination mb-0">
        @if($data->prev_page_url)
            <li class="page-item"><a class="page-link" href="{{ $data->prev_page_url }}" aria-label="Previous"><span aria-hidden="true">&laquo;</span><span class="sr-only">Previous</span></a></li>
        @endif
        @for ($i = ($data->current_page > 2 ? $data->current_page - 2 : 1); $i <= ($data->to > 2 ? ($data->to - $data->current_page > 2 ? $data->current_page + 2 : $data->to) : $data->to); $i++)
            @if ($i == $data->current_page)
                <li class="page-item active"><a class="page-link" href="{{ $endpoint }}?page={{ $i }}">{{ $i }}</a></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $endpoint }}?page={{ $i }}">{{ $i }}</a></li>
            @endif
        @endfor
        @if($data->next_page_url)
            <li class="page-item"><a class="page-link" href="{{ $data->next_page_url }}" aria-label="Next"><span aria-hidden="true">&raquo;</span><span class="sr-only">Next</span></a></li>
        @endif
    </ul>
</div>
