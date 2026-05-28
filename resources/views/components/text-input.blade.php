@props(['disabled' => false])

<input @disabled($disabled) {{ $attributes->merge(['class' => 'border-gray-300 focus:border-green-500 focus:ring-green-500 rounded-lg shadow-sm text-gray-900 placeholder-gray-400 w-full']) }}>
