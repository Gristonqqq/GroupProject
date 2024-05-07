const openButton = document.getElementById('open-button');
const popup = document.getElementById('popup');
const closeButton = document.getElementById('close-button');

// Відкрити вспливаюче вікно
function openPopup() {
  popup.style.display = 'block';
}

// Закрити вспливаюче вікно
function closePopup() {
  popup.style.display = 'none';
}

// Додати обробник події для відкриття вспливаючого вікна
openButton.addEventListener('click', openPopup);

// Додати обробник події для закриття вспливаючого вікна
closeButton.addEventListener('click', closePopup);
