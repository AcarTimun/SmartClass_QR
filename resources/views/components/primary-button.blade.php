<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex justify-center items-center px-6 py-3 bg-indigo-600 border border-transparent rounded-full font-bold text-sm text-white tracking-wide hover:bg-indigo-700 focus:bg-indigo-700 active:bg-indigo-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 transition-all duration-200 ease-in-out transform hover:-translate-y-0.5 shadow-lg shadow-indigo-500/30']) }}>
    {{ $slot }}
</button>
