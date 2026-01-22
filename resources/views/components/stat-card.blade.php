<div class="bg-white p-5 rounded-xl border-2 border-slate-200 shadow-md flex items-center hover:shadow-xl transition-shadow duration-300">
  <div class="{{ $color }} p-3.5 rounded-xl text-white mr-4 shadow-xl border border-white/20">
    {!! $icon ?? '' !!}
  </div>
  <div>
    <p class="text-slate-700 text-xs uppercase font-black tracking-[0.15em] mb-0.5">{{ $label }}</p>
    <h4 class="text-3xl font-black text-slate-900 tracking-tight leading-none">{{ $value }}</h4>
  </div>
</div>
