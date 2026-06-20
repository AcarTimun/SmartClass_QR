@props(['disabled' => false, 'readonly' => false])

<input @disabled($disabled) @readonly($readonly) {{ $attributes->merge(['class' => 'border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 rounded-xl shadow-sm px-4 py-3 text-slate-800 placeholder-slate-400 transition duration-200 w-full ' . ($readonly ? 'bg-slate-100 text-slate-500 cursor-not-allowed' : 'bg-white')]) }}>
