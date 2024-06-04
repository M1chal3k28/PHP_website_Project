// Observer checks if elemnt is visible / if true show element and unobserve it - element can be shown only once
const observer = new IntersectionObserver((entries)=>{
    entries.forEach((entry) => 
    {
        if (entry.isIntersecting){
          entry.target.classList.add('show');

          observer.unobserve(entry.target);
        } 
    });
});
const hiddenElements = document.querySelectorAll('.hidden');
hiddenElements.forEach((el) => observer.observe(el));

/* button menu dropdown*/

  const myFunction = x => {
    x.classList.toggle("change");
    document.getElementById("myDropdown").classList.toggle("show");
  }; 

  // Close the dropdown menu if the user clicks outside of it
  window.onclick = function(event) {
    if (!event.target.matches('.myDropdown') &&
        !event.target.matches('.menu') &&
        !event.target.matches('.bar1') &&
        !event.target.matches('.bar2') &&
        !event.target.matches('.bar3') &&
        !event.target.matches('.dropbtn')) {
      var dropdowns = document.getElementsByClassName("dropdown-content");
      var buttons = document.getElementsByClassName("dropbtn");
      var i;
      for (i = 0; i < dropdowns.length; i++) {
        var openDropdown = dropdowns[i];
        var openButton = buttons[i];
        if (openDropdown.classList.contains('show')) {
          openDropdown.classList.remove('show');
        }

        if(openButton.classList.contains('change')) {
          openButton.classList.remove('change');
        }
      }
    }
  };