<div {{ $attributes->merge([
    'class' => 'accordion',
    'id' => $id = $id.'-accordion'
  ]) }}>
  {!! $slot !!}

  {{ @$deneme }}
</div>
