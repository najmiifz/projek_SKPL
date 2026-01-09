<div class="bg-white p-5 rounded-xl border border-slate-100 shadow-sm flex items-center">
  <div class="{{ $color }} p-3 rounded-lg text-white mr-4 shadow-lg shadow-blue-500/10">
    {!! $icon ?? '' !!}
  </div>
  <div>
    <p class="text-slate-500 text-xs uppercase font-bold tracking-wider">{{ $label }}</p>
    <h4 class="text-2xl font-bold text-slate-800">{{ $value }}</h4>
  </div>
</div>
