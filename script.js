document.addEventListener("DOMContentLoaded", function() {
    console.log("The DOM is fully loaded and parsed");
    
    let navItems = document.querySelectorAll("nav ul li a");
    
    navItems.forEach(item => {
        item.addEventListener("click", function(event) {
            console.log("You clicked on: ", event.target.textContent);
            // Add your code here.
        });
    });
});
