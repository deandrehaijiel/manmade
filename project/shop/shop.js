function loadMore() {
    const loadMoreGif = document.getElementById('loadmoregif');
    loadMoreGif.style.display = 'inline';

    const loadMoreButton = document.getElementById('loadmorebutton');
    loadMoreButton.style.display = 'none';

    setTimeout(() => {
        const hiddenShoes = document.querySelectorAll('.hidden-shoes');
        hiddenShoes.forEach(shoe => {
            shoe.style.display = 'flex';
        });
        loadMoreGif.style.display = 'none';
    }, 2000); 
}