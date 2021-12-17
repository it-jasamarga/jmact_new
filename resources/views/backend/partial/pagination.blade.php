<nav aria-label="Page navigation example">
    @if ($paginator->lastPage() > 1)
        <ul class="pagination justify-content-center mt-2">
            <li class="page-item prev">
                <a class="page-link" href="{{ ($paginator->currentPage() == 1) ? 'javascript:void(0)' : $paginator->url(1) }}">Prev</a>
            </li>

            @php
                $out      = '';
                $isGap    = false; 
                $cntAround = 1;
                $current  = $paginator->currentPage();
                $cntPages = $paginator->lastPage();
            @endphp
            @for ($i = 1; $i <= $paginator->lastPage(); $i++)
                @php
                    $isGap = false;
                    if ($cntAround >= 0 && $i > 0 && $i < $cntPages - 1 && abs($i - $current) > $cntAround) { 
                        $isGap    = true;
                        $i = ($i < $current ? $current - $cntAround : $cntPages - 1) - 1;
                    }

                @endphp
                <li class="page-item {{ ($paginator->currentPage() == $i) ? ' active' : '' }}">
                    @if(($i != $current) && (!$isGap))
                        <a class="page-link" href="{{$paginator->url($i)}}">{{$i}}</a>
                    @else
                        <a class="page-link" href="{{ ($isGap) ? '-' : $i }}">{{ ($isGap) ? '...' : $i }}</a>
                    @endif
                </li>
            @endfor
            <li class="page-item next">
                <a class="page-link" href="{{ ($paginator->currentPage() == $paginator->lastPage()) ? 'javascript:void(0)' : $paginator->url($paginator->currentPage()+1) }}">Next</a>
            </li>
        </ul>
    @endif
</nav>