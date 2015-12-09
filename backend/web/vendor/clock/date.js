var monthNames = ["Январь", "Февраль", "Март", "Апрель", "Май", "Июнь",
    "Июль", "Август", "Сентябрь", "Октябрь", "Ноябрь", "Декабрь"
];
var dayNames = ["Пн, ", "Вт, ", "Ср, ", "Чт, ", "Пт, ", "Сб, ", "Вс, "];

var newDate = new Date();
newDate.setDate(newDate.getDate() + 1);
$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());
