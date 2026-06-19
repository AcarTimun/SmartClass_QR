@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-slate-200 focus:border-indigo-500 focus:ring-indigo-500 focus:ring-2 rounded-xl shadow-sm px-4 py-3 bg-white text-slate-800 placeholder-slate-400 transition duration-200 w-full']) }}>
