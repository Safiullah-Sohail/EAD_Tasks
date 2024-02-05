<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Weather Search</title>
  <link rel="stylesheet" href="./css/tailwind.min.css">
  <link rel="stylesheet" href="./css/style.css">
  <script src="./js/jquery.min.js"></script>
</head>

<body class="bg-gray-100 flex items-center justify-center h-screen">

  <div class="container mx-auto flex flex-wrap justify-around m-10">
    <div class="w-full md:w-1/2 lg:w-1/3">
      <div class="search-box">
        <div class="search-heading">Enter city name to retrieve current weather</div>
          <div class="relative w-full">
            <input type="text" id="citySearch" class="search-input" placeholder="Search City..." required>
          </div>
        <button id="searchWeather" class="ml-2 bg-black text-white px-4 py-2 rounded">Search</button>
      </div>

      <div id="weatherDetails" class="hidden w-full p-6 rounded-lg shadow-md mt-4" style="background-color: #232222;">
        <h2 class="text-3xl font-semibold mb-4 text-center text-gray-100">Weather Details</h2>
        <div id="weatherInfo" class="text-lg mb-4 search-input">
          <p id="temperature" class="mb-2 text-gray-100"></p>
          <p id="description" class="text-gray-100"></p>
        </div>
        <p id="weatherError" class="text-red-500 hidden mt-4 text-center">Failed to fetch weather details. Please try
          again later.</p>
      </div>
    </div>
  </div>

  <script>
    $(document).ready(function () {
      $('#searchWeather').on('click', function () {
        var cityName = $('#citySearch').val().trim();
        $('#temperature, #description, #weatherError').text('').addClass('hidden');
        $('#weatherDetails').removeClass('hidden');
        $.ajax({
          url: './api/getWeather.php',
          type: 'GET',
          data: { cityName: cityName },
          success: function (response) {
            try {
              var weatherDetails = JSON.parse(response);
              if (weatherDetails && weatherDetails.temperature !== undefined && weatherDetails.description !== undefined) {
                $('#temperature').text('Temperature: ' + weatherDetails.temperature);
                $('#description').text('Description: ' + weatherDetails.description);
                $('#temperature, #description').removeClass('hidden');
              } else {
                console.log('Temperature or description is undefined in the JSON response:', weatherDetails);
                $('#weatherError').text('Invalid data in the JSON response. Please try again later.').removeClass('hidden');
              }
            } catch (error) {
              console.log('Error parsing JSON: ', error);
              $('#weatherError').text('Error parsing the JSON response. Please try again later.').removeClass('hidden');
            }
          },
          error: function (xhr, status, error) {
            console.log('AJAX error:', xhr.responseText, status, error);
            // Display error message on UI
            $('#weatherError').text('Failed to fetch weather details. Please try again later.').removeClass('hidden');
          }
        });
      });
    });
  </script>
</body>

</html>
