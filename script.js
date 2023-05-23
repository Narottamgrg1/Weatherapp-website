let weather = {
  fetchWeather: function () {
    console.log("fetchWeather function is being called.");
    fetch("http://localhost/weather.php?city=Bradford")
      .then((response) => {
        if (!response.ok) {
          alert("No weather found.");
          throw new Error("No weather found.");
        }
        return response.json();
      })
      .then((data) => this.displayWeather(data));
  },
  displayWeather: function (data) {
    const { city, temp, humidity, wind,date_time } = data;
    document.querySelector('.city').innerText = "Weather in " + city;
    document.querySelector(".temp").innerText = temp + "°C";
    document.querySelector(".humidity").innerText =
      "Humidity: " + humidity + "%";
    document.querySelector(".wind").innerText =
      "Wind speed: " + wind + " km/h";
      document.querySelector(".time").innerText =
      "Datetime: " + date_time ;
    document.querySelector(".weather").classList.remove("loading");
  },
  search: function () {
    this.fetchWeather();
  },
};

// document.querySelector(".search button").addEventListener("click", function () {
//   weather.search();
// });

document.querySelector(".search-bar").addEventListener("keyup", function (event) {
  if (event.key == "Enter") {
    weather.search();
  }
});

weather.fetchWeather();