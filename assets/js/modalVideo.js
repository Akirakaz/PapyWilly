const modalsPreview = document.querySelectorAll('[data-modalpreview]');
modalsPreview.forEach(function (trigger) {
  trigger.addEventListener('click', function () {
    const youtubeEmbedSrc = "https://www.youtube.com/embed/";
    const iframeVideo = document.getElementById('iframeVideo');
    const modal = document.getElementById(this.dataset.modalpreview);
    const lightbox = document.createElement('div');
    const modalText = document.createElement('span');

    iframeVideo.setAttribute('src', youtubeEmbedSrc + this.dataset.video);
    lightbox.classList.add('absolute', 'h-full', 'w-full', 'cursor-zoom-out', 'bg-slate-900/80', 'modal-exit');
    modalText.classList.add('text-slate-400', 'z-1');
    modalText.innerHTML = "Cliquez en dehors de la vidéo pour fermer ou la touche [Echap]";
    modal.classList.add('!visible', 'opacity-100');
    modal.appendChild(lightbox);
    modal.append(modalText);

    function closeModal() {
      modal.classList.remove('!visible', 'opacity-100');
      lightbox.remove();
      iframeVideo.removeAttribute('src');
      modalText.remove();
    }

    const exits = modal.querySelectorAll('.modal-exit');
    exits.forEach(function (exit) {
      exit.addEventListener('click', function (event) {
        event.preventDefault();
        closeModal();
      });
    });

    window.addEventListener('keydown', function (event) {
      if (event.key === 'Escape') {
        closeModal();
      }
    });
  });
});