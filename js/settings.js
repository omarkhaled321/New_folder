$(document).ready(function() {
    // Function to handle file input change
    $('.account-settings-fileinput').on('change', function() {
        var input = $(this)[0];
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                // Display the selected image preview
                $('.media img').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]);
        }
    });
});

let sidebar = document.querySelector('.sidebar');
let menu = document.querySelector('#menu');

menu.addEventListener('click', () => {
    sidebar.classList.toggle('active');
});

//copy menu for mobile
function copyMenu() {
    var dptCategory = document.querySelector('.dpt-cat');
    var dptPlace = document.querySelector('.departments');
    dptPlace.innerHTML = dptCategory.innerHTML;

    var mainNav = document.querySelector('.header-nav nav');
    var navPlace = document.querySelector('.off-canvas nav');
    navPlace.innerHTML = mainNav.innerHTML;

    var topNav = document.querySelector('.header-top .wrapper');
    var topPlace = document.querySelector('.off-canvas .thetop-nav');
    topPlace.innerHTML = topNav.innerHTML;
}
copyMenu();
//show mobile menu
const menuButton = document.querySelector('.trigger'),
      closeButton = document.querySelector('.t-close'),
    addclass = document.querySelector('.site');
menuButton.addEventListener('click', function() {
    addclass.classList.toggle('showmenu')
})
closeButton.addEventListener('click', function() {
    addclass.classList.remove('showmenu')
})


//show sub menu on mobile
const submenu = document.querySelectorAll('.has-child .icon-small');
submenu.forEach((menu) => menu.addEventListener('click', toggle));

function toggle(e) {
    e.preventDefault();
    submenu.forEach((item) => item != this ? item.closest('.has-child').classList.remove('expand') : null);
    if (this.closest('.has-child').classList != 'expand');
    this.closest('.has-child').classList.toggle('expand');
}


//show search
const searchButton = document.querySelector('.t-search'),
      tClose = document.querySelector('.search-close'),
      showClass = document.querySelector('.site');
searchButton.addEventListener('click', function(){
    showClass.classList.toggle('showsearch')
})
tClose.addEventListener('click', function(){
    showClass.classList.remove('showsearch')
})

//show dpt menu
const dptButton = document.querySelector('.dpt-cat .dpt-trigger'),
      dptClass = document.querySelector('.site');
dptButton.addEventListener('click', function(){
    dptClass.classList.toggle('showdpt')
})



// stock products bar width percentage
var stocks = document.querySelectorAll('.products .stock');
for (let x = 0; x < stocks.length; x++){
    let stockElement = stocks[x].querySelector('.qty-sold'); // Corrected variable name
    let availableElement = stocks[x].querySelector('.available');
    
    console.log('Stock element:', stockElement);
    console.log('Available element:', availableElement);
    
    if (stockElement && availableElement) {
        let stock = stocks[x].dataset.stock;
        let available = stockElement.innerHTML;
        let sold = stockElement.innerHTML; // Corrected variable name
        let percent = sold * 100 / stock;

        availableElement.style.width = percent + '%';
    }
}



// show cart on click
const divtoShow = '.mini-cart';
const divPopup = document.querySelector(divtoShow);
const divTrigger = document.querySelector('.cart-trigger');

divTrigger.addEventListener('click', () => {
    setTimeout(() => {
        if(!divPopup.classList.contains('show')){
            divPopup.classList.add('show')
        }
    }, 250 )
})

// auto close by click outside
document.addEventListener('click', (e) => {
    const isClosest = e.target.closest(divtoShow);
    if(!isClosest && divPopup.classList.contains('show')) {
        divPopup.classList.remove('show')
    }
})












