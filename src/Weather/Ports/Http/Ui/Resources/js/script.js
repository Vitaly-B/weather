import '../css/style.css'

import $ from 'jquery';

$(document).ready(function () {
    $('#city_form_city').change(function () {
        console.log($(this).val());

        let city = $(this).val();

        $('#weather-info').html("");

        if (city) {
            $('#weather-info').html(
                '<div class="spinner-border" role="status">\n' +
                '  <span class="visually-hidden">Loading...</span>\n' +
                '</div>'
            );

            $.ajax({
                url: '/api/weather/current',
                type: 'GET',
                data: {city: city},
                dataType: 'json',
                success: function (data) {
                    console.log(data);

                    const lastUpdate = new Date(
                        data.data.last_updated.date
                    );

                    const formatter = new Intl.DateTimeFormat('default', {
                        year: 'numeric',
                        month: '2-digit',
                        day: '2-digit',
                        hour: '2-digit',
                        minute: '2-digit',
                        hour12: false
                    });

                    $('#weather-info').html(
                        '<div><strong>City:</strong> ' + data.data.city + '</div>\n' +
                        '<div><strong>Country:</strong> ' + data.data.country + '</div>\n' +
                        '<div><strong>Temperature:</strong> ' + data.data.temperature + '</div>\n' +
                        '<div><strong>Condition:</strong> ' + data.data.condition + '</div>\n' +
                        '<div><strong>Humidity:</strong> ' + data.data.humidity + '</div>\n' +
                        '<div><strong>Wind speed:</strong> ' + data.data.wind_speed + '</div>\n' +
                        '<div><strong>Last updated:</strong> ' + formatter.format(lastUpdate) + '</div>\n'
                    );
                },
                error: function (xhr) {
                    $('#weather-info').html("");

                    const contentType = xhr.getResponseHeader('Content-Type');

                    if (contentType && contentType.includes('application/json')) {
                        const data = JSON.parse(xhr.responseText);
                        $('#weather-info').html('<div class="alert alert-danger">' + data.message + '</div>');
                    } else {
                        $('#weather-info').html('<div class="alert alert-danger">' + xhr.responseText + '</div>');
                    }
                }
            });
        }
    });
})