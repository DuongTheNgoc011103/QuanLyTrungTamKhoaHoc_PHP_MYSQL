document.addEventListener('DOMContentLoaded', function() {
    
    function ActiveNavLink() {
        const pathName = window.location.pathname;
        const pageName = pathName.split("/").pop();
    
        if (pageName == "home.php") {
            document.querySelector(".home").classList.add("active");
        }
        if (pageName == "khoahoc.php") {
            document.querySelector(".khoahoc").classList.add("active");
        }
    }
    
    ActiveNavLink(); // This function is common for all pages

});
