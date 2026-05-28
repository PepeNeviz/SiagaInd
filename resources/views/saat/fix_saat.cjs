const fs = require('fs');
const file = 'c:/xampp/htdocs/SiagaInd/resources/views/saat/index.blade.php';
let content = fs.readFileSync(file, 'utf8');

// Fix currentDisasterIcon bug
content = content.replace(/x-text="currentDisasterIcon"/g, 'x-html="currentDisasterIcon"');

// Map remaining emojis
const mappings = {
    '🏠': '<i class="fa-solid fa-house text-green-700"></i>',
    '🧍': '<i class="fa-solid fa-person text-gray-700"></i>',
    '👨‍👩‍👧': '<i class="fa-solid fa-people-group text-blue-600"></i>',
    '🧒': '<i class="fa-solid fa-child-reaching text-orange-500"></i>',
    '👌': '<i class="fa-solid fa-thumbs-up text-green-500"></i>',
    '➡️': '<i class="fa-solid fa-arrow-right text-blue-500"></i>',
    '🏙️': '<i class="fa-solid fa-city text-gray-500"></i>',
    '🫨': '<i class="fa-solid fa-house-crack text-orange-600"></i>',
    '👵': '<i class="fa-solid fa-person-cane text-purple-500"></i>',
    '🚶': '<i class="fa-solid fa-person-walking text-green-600"></i>',
    '🚗': '<i class="fa-solid fa-car text-red-500"></i>',
    '🛋️': '<i class="fa-solid fa-couch text-amber-700"></i>',
    '🛣️': '<i class="fa-solid fa-road text-gray-600"></i>',
    '📈': '<i class="fa-solid fa-arrow-trend-up text-red-600\"></i>',
    '🔌': '<i class="fa-solid fa-plug text-gray-500\"></i>',
    '✅': '<i class="fa-solid fa-circle-check text-green-500\"></i>',
    '⬆️': '<i class="fa-solid fa-arrow-up text-blue-500\"></i>',
    '❌': '<i class="fa-solid fa-circle-xmark text-red-600\"></i>',
    '🛟': '<i class="fa-solid fa-life-ring text-orange-500\"></i>',
    '🌫️': '<i class="fa-solid fa-cloud text-gray-400\"></i>',
    '💨': '<i class="fa-solid fa-wind text-gray-400\"></i>',
    '🔄': '<i class="fa-solid fa-rotate text-blue-500\"></i>',
    '❄️': '<i class="fa-solid fa-snowflake text-cyan-400\"></i>',
    '🪜': '<i class="fa-solid fa-stairs text-amber-800\"></i>',
    '🪟': '<i class="fa-solid fa-border-all text-blue-300\"></i>',
    '😵': '<i class="fa-solid fa-face-dizzy text-yellow-600\"></i>'
};

for (const [emoji, fa] of Object.entries(mappings)) {
    content = content.split(emoji).join(fa);
}

fs.writeFileSync(file, content);
console.log('Fixed x-text bug and replaced emojis.');
