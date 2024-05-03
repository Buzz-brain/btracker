let openMenu = document.getElementById("openMenu");
let menuOverlay = document.getElementsByClassName("menuOverlay")[0];
let remove = document.getElementsByClassName("remove")[0];

openMenu.addEventListener("click", function () {
  menuOverlay.style.transform = "translate(0%)";
  openMenu.src = "menuSwitch.png"
});
remove.addEventListener("click", function () {
  menuOverlay.style.transform = "translate(-100%)";
  openMenu.src = "menu.png"
});



const checkError = (error) => {
  switch (error.name) {
      case 'TypeError':
        locationDiv.innerText = 'Type error occurred:', error.message;
        locationMap.innerText = 'Type error occurred:', error.message;
        if (error.message === 'Failed to fetch') {
          locationDiv.innerText = 'Network request failed. Check your connection.';
          locationMap.innerText = 'Network request failed. Check your connection.';
        }
        break;
      case 'AbortError':
        locationDiv.innerText = 'The fetch operation was aborted.';
        locationMap.innerText = 'The fetch operation was aborted.';
        break;
      default:
        locationDiv.innerText = 'An error occurred:', error;
        locationMap.innerText = 'An error occurred:', error;
        break;
    }

  switch (error.code) {
    case error.PERMISSION_DENIED:
      locationDiv.innerText = "Please allow access to location";
      locationMap.innerText = "Please allow access to location";
      break;
    case error.POSITION_UNAVAILABLE:
      locationDiv.innerText = "Location Information unavailable";
      locationMap.innerText = "Unable to get map location";
      break;
    case error.TIMEOUT:
      locationDiv.innerText = "The request to get user location timed out";
      locationMap.innerText = "The request to get map location timed out";
      break;
    case error.UNKNOWN_ERROR:
      locationDiv.innerText = "An unknown error occured. Please refresh";
      locationMap.innerText = "An unknown error occured. Please refresh";
      break;
    case error.ERR_CONNECTION_TIMED_OUT:
      locationDiv.innerText = "An unknown error occured. Please refresh";
      locationMap.innerText = "An unknown error occured. Please refresh";
      break;
    default:
      locationDiv.innerText = "An unknown error occured. Please refresh";
      locationMap.innerText = "An unknown error occured. Please refresh";

  }
  // 
  removeClassList()
};

function init(locationData) {

    $.ajax({
      type: "POST",
      url: "dashboard.php", // PHP file to handle the data
      data: locationData,
      success: function(response) {
          // Handle success response
          // console.log("Data sent successfully");
          // console.log("Response from server: Location history updated");
      },
      error: function(xhr, status, error) {
          // Handle error
          console.error("Error sending data: " + error);
      }
  });
 
}


  
const showLocation = async (position) => {
  var latitude = position.coords.latitude;
  var longitude = position.coords.longitude;

  let response = await fetch(
    `https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`
  );
  
  // https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json
  // https://api.opencagedata.com/geocode/v1/json?key=f20ed75b5425479eb2978b608434b0c1&q=${latitude}+${longitude}&pretty=1&no_annotations=1
  // f20ed75b5425479eb2978b608434b0c1 // Api key

  let data = await response.json();
  locationDiv.innerText = `${data.display_name}`; //openstreetmap
  // locationDiv.innerText = `${data.results[0].formatted}`; //opencagedata

  locationMap.innerText = "";
  locationMap.style.border = "none";
  
  let map = document.createElement("iframe");
  map.style.width = "100%";
  map.style.height = "100%";
  map.src = 
    "https://maps.google.com/maps?q=" +
    position.coords.latitude +
    "," +
    position.coords.longitude +
    "&output=embed";
  let mapLocation = "https://maps.google.com/maps?q=" +
  position.coords.latitude +
  "," +
  position.coords.longitude +
  "&output=embed";
  locationMap.append(map);


  let locationData = {
    locationName: data.display_name,
    mapLocation: mapLocation,
};
  // Send AJAX request
  init(locationData)

  removeClassList()
};

var refreshIcon = document.getElementById('refreshIcon');

window.onload = function () {
    let locationDiv = document.getElementById("locationDiv");
    let locationMap = document.getElementById("locationMap");
    locationDiv.innerText = "Getting Location...";
    locationMap.innerText = "Getting Map Location...";
    locationMap.style.border = "1px solid darkblue";
    if ("geolocation" in navigator) {
      addClassList()
      const options = {
        enableHighAccuracy: true,  // Use GPS for high accuracy
        timeout: 80000,             // Timeout in milliseconds (30 seconds)
        maximumAge: 0              // Force a fresh location reading
      };
        // navigator.geolocation.getCurrentPosition(showLocation, checkError, options); 
        navigator.geolocation.watchPosition(showLocation, checkError, options); 
      } else {
        locationDiv.innerText = "The browser does not support geolocation";
      }
};

//Refresh every 3 minutes
// setInterval(() => {
//   window.onload()
// }, 180000)

 // JavaScript to toggle rotation
refreshIcon.addEventListener("click", function() {
    window.onload()
}) 

function addClassList() {
  refreshIcon.classList.add('rotate');
}
function removeClassList() {
  refreshIcon.classList.remove('rotate');
}
