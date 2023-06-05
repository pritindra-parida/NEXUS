const body = document.querySelector('body'),
      sidebar = body.querySelector('nav'),
      toggle = body.querySelector(".toggle"),
      modeSwitch = body.querySelector(".toggle-switch"),
      modeText = body.querySelector(".mode-text");


toggle.addEventListener("click" , () =>{
    sidebar.classList.toggle("close");
})

// searchBtn.addEventListener("click" , () =>{
//     sidebar.classList.remove("close");
// })

modeSwitch.addEventListener("click" , () =>{
    body.classList.toggle("dark");
    
    if(body.classList.contains("dark")){
        modeText.innerText = "Light mode";
    }else{
        modeText.innerText = "Dark mode";
        
    }
});


// Variables for Buttons

var home_btn = document.getElementById("home_btn");
var create_btn = document.getElementById("create-event");
var your_events_btn = document.getElementById("your_events_btn");
var attendees_btn = document.getElementById("attendees_btn");
var notification_btn = document.getElementById("notification_btn");
var settings_btn = document.getElementById("settings_btn");
var cancel_btn = document.getElementById("cancel");
var logout_btn = document.getElementById("logout_btn");
var search_btn = document.getElementById("search-btn");
var section_ids = ["home", "your_events", "event_attendees", "notification", "settings", "event-form"];


// Adding Eventlistners to Button Variables

home_btn.addEventListener("click", function(){getFocus("home")});
your_events_btn.addEventListener("click", function(){getFocus("your_events")});
attendees_btn.addEventListener("click", function(){getFocus("event_attendees")});
notification_btn.addEventListener("click", function(){getFocus("notification")});
settings_btn.addEventListener("click", function(){getFocus("settings")});
create_btn.addEventListener("click", function(){getFocus("event-form")});
cancel_btn.addEventListener("click", function(){getFocus("home")});
search_btn.addEventListener("click", function(){getFocus("event_attendees")});



function getFocus(section_id){
    var section_classlist = document.getElementById(section_id).classList;
    // console.log(section_classlist.contains("visible"));

    if(section_classlist.contains("visible")){

    }else{
        section_classlist.remove("invisible");
        section_classlist.add("visible");

        for(var i =0; i<section_ids.length; i++){
            if(section_ids[i]===section_id){
                continue;
            }
            document.getElementById(section_ids[i]).classList.add("invisible");
            document.getElementById(section_ids[i]).classList.remove("visible");
        }
    }
}




// Dynamic Input Generation for Speakers and Organizers
$(document).ready(function() {
        // Generate speaker details fields
        $("#speaker-number").on("input", function() {
          var speakerCount = $(this).val();
          var speakerDetails = $("#speaker-details");
          speakerDetails.empty();
          for (var i = 1; i <= speakerCount; i++) {
            var speakerName = $("<input>")
              .addClass("form-control")
              .attr("type", "text")
              .attr("name", "speaker-name-" + i)
              .attr("placeholder", "Enter speaker name " + i);
            var speakerAbout = $("<textarea>")
              .addClass("form-control")
              .attr("rows", "3")
              .attr("name", "speaker-about-" + i)
              .attr("placeholder", "Enter about speaker " + i);
            var speakerHeading = $("<h4>")
              .addClass("mt-4")
              .text("Speaker " + i);
            var speakerNameHeading = $("<h5>")
              .addClass("mt-3")
              .text("Name of Speaker");
            var speakerAboutHeading = $("<h5>")
              .addClass("mt-3")
              .text("About Speaker " + i);
            speakerDetails.append(speakerHeading, speakerNameHeading, speakerName, speakerAboutHeading, speakerAbout);
          }
        });

        // Generate organizer name input fields
        $("#organizer-number").on("input", function() {
          var organizerCount = $(this).val();
          var organizerNames = $("#organizer-names");
          organizerNames.empty();
          for (var i = 1; i <= organizerCount; i++) {
            var organizerName = $("<input>")
              .addClass("form-control")
              .attr("type", "text")
              .attr("name", "organizer-name-" + i)
              .attr("placeholder", "Enter organizer name " + i);
            var organizerNameHeading = $("<h5>")
              .addClass("mt-3")
              .text("Name of Organizer " + i);
            organizerNames.append(organizerNameHeading, organizerName);
          }
        });
      });


// logout function
function logout() {
  // Make an AJAX request to the PHP file that handles logout
  var xhr = new XMLHttpRequest();
  xhr.open("GET", "../partials/_functions.php", true);
  xhr.onreadystatechange = function() {
    if (xhr.readyState === 4 && xhr.status === 200) {
      // Handle the response if needed
      console.log(xhr.responseText);
      // Optionally, redirect to a different page after logout
      window.location.href = "../login.php";
    }
  };
  xhr.send();
}