/**
 * Tailwind CSS Configuration for Laravel + Vite + Blade
 * https://tailwindcss.com/docs/configuration
 */
module.exports = {
  content: [
    './resources/views/**/*.blade.php',
    './resources/js/**/*.js',
    './resources/css/**/*.css',
    './app/Livewire/**/*.php',
    './app/View/Components/**/*.php',
  ],
  safelist: [
    // Add your custom or dynamic classes here. Example:
    'bg-gradient-to-br',
    'from-blue-700',
    'via-blue-900',
    'to-cyan-500',
  'text-8xl',
  'text-yellow-400',
  'text-blue-600',
    'hover:scale-105',
    'hover:scale-110',
    'hover:shadow-2xl',
    'dark:bg-gray-900',
    // Add more as needed
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
