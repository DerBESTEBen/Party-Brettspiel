document.querySelectorAll('.menu-list a').forEach(item => {
            item.addEventListener('mouseover', () => {
                item.style.color = 'blue';
            });
            item.addEventListener('mouseout', () => {
                item.style.color = 'black';
            });
        });