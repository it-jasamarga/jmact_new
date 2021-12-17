@foreach($menu as $submenu)
	@php
        $filter = $submenu->perms;
        $confirm = auth()->user()->getAllPermissions()->filter(function ($q) use ($filter) {
            return starts_with($q->name, $filter);
        })->count();
    @endphp

    @if($confirm > 0)
	<li class="menu-item {{ (request()->is($submenu->url)) ? 'menu-item-active' : 'menu-item-submenu' }}" aria-haspopup="true" data-menu-toggle="hover">
	    <a href="{{ url($submenu->url) }}" class="menu-link menu-toggle">
	        <i class="menu-bullet menu-bullet-line">
	            <span></span>
	        </i>
	        <span class="menu-text">{{ $submenu->name }}</span>
	        <!-- <span class="menu-label">
	            <span class="label label-rounded label-primary">6</span>
	        </span> -->
	    </a>

	</li>
	@endif
@endforeach