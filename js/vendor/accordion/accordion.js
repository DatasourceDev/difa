var acc = document.getElementsByClassName("accordion");
var i;

for (i = 0; i < acc.length; i++) {
   acc[i].addEventListener("click", function () {
      /* Toggle between adding and removing the "active" class,
      to highlight the button that controls the panel */
      this.classList.toggle("active");

      /* Toggle between hiding and showing the active panel */
      var panel = this.nextElementSibling;
      if (panel.style.display === "block") {
         panel.style.display = "none";
      } else {
         panel.style.display = "block";
      }
      if (this.getElementsByClassName("glyphicon-chevron-down")[0] != null)
         this.getElementsByClassName("glyphicon-chevron-down")[0].className = "glyphicon glyphicon-chevron-up";
      else if (this.getElementsByClassName("glyphicon-chevron-up")[0] != null)
         this.getElementsByClassName("glyphicon-chevron-up")[0].className = "glyphicon glyphicon-chevron-down";
   });

}