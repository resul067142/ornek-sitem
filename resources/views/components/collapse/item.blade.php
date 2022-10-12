@php
$explode = explode('_', $id);
@endphp
<div class="accordion-item">
	<h2 class="accordion-header">
	  <button class="accordion-button {{ @$show ? '' : 'collapsed' }}" type="button" data-bs-toggle="collapse" data-bs-target="#{{ $explode[1] }}" aria-expanded="{{ @$show ? 'true' : 'false' }}">
	    Accordion Item #1
	  </button>
	</h2>
	<div id="{{ $explode[1] }}" class="accordion-collapse collapse {{ @$show ? 'show' : '' }}" data-bs-parent="#{{ $explode[0] }}">
	  <div class="accordion-body">{!! $slot !!}</div>
	</div>
</div>
