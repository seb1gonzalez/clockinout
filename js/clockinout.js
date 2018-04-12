function loadUserInfo(eId) {
    $.getJSON("backend/public/api/employee/" + eId, function (userInfo) {
        $('#modalLabel').html(userInfo.name);
        // $('#classification').html(userInfo.classification);
        $('#user-logs tbody tr').remove();
        userLogs = $.getJSON("backend/public/api/userLogs/" + eId, function (userLogs) {
            inorout = 1;
            for (var i = 0; i < userLogs.length; i++) {
                time = userLogs[i];
                if (inorout) {
                    inoroutMessage = 'In';
                    inorout = 0;
                } else {
                    inoroutMessage = 'Out';
                    inorout = 1;
                }
                tr = '<tr>\
                <td>'+ time + '</td>\
                <td>'+ inoroutMessage + '</td>\
                </tr>';
                $('#user-logs').append(tr);
            }
        });

    });
}
function loadBarChart(eId) {
    $.get("backend/public/api/weeklyLog/" + eId, function (response) {
        totalHours = 0;
        for (var j = 1; j < response.length; j++) {
            currDate = new Date(response[j]);
            prevDate = new Date(response[j - 1]);
            hours = ((currDate - prevDate) / 1000) / 3600;
            totalHours += hours;
        }

        var myChart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: ["Weekly Hours"],
                datasets: [{
                    label: '# of hours',
                    data: [totalHours.toFixed(2)],
                    backgroundColor: 'rgb(102, 172, 226)'
                }]
            },
            options: {
                legend: {
                    display: false
                },
                scales: {
                    yAxes: [{
                        ticks: {
                            beginAtZero: true
                        }
                    }]
                }
            }
        });
    });
}

function timeTable(){
    $('#users-in tbody tr').remove();
    $.getJSON("backend/public/api/usersLogs", function (usersin) {
        for (var i = 0; i < usersin.length; i++) {
            button = '<button class="btn btn-info btn-block employee-log" data-toggle="modal" data-target="#modal" data-id="' + usersin[i][0] + '">' + usersin[i][1] + '</button>';
            row = '<tr>';
            placed = 0;
            $timezone_offset = 0;

            for (var j = 2; j < (usersin[i].length); j++) {
                // start position of the current entry
                displacement = positions[parseInt(usersin[i][j].substr(0, 2)) - $timezone_offset];
                // end position of the current entry
                odd = false;
                if ((j + 1) >= usersin[i].length) {
                    odd = true;
                    nextDisplacement = positions[n];
                } else {
                    nextDisplacement = positions[parseInt(usersin[i][j + 1].substr(0, 2)) - $timezone_offset];
                }
                td = '';

                // if it starts at 6
                if (displacement == 0) {
                    td = '<td colspan="' + (nextDisplacement + 1) + '">';
                    td = td + button;
                    td = td + '</td>';
                    placed = placed + nextDisplacement + 1;
                    row = row + td;
                    j++;
                } else {
                    if ((displacement - placed) != 0) {
                        td = '<td colspan="' + (displacement - placed) + '"></td>';
                    }
                    td = td + '<td colspan="' + (nextDisplacement - displacement + 1) + '">';
                    td = td + button;
                    td = td + '</td>';
                    placed = placed + nextDisplacement + 1;
                    row = row + td;
                    j++;
                }
            }

            row = row + '</tr>';
            $('#users-in tbody').append(row);
        }
    });
}

function loadUsers() {
    $('#users-out-list').html('');
    $('#users-in-list').html('');
    $.getJSON("backend/public/api/employeesOut", function (usersout) {
        for (var i = 0; i < usersout.length; i++) {
            button = '<button class="btn btn-warning btn-block" data-toggle="modal" data-target="#modal" disabled>' + usersout[i] + '</button>';
            $('#users-out-list').append(button)
        }
    });
    $.getJSON("backend/public/api/employeesIn", function (usersin) {
        for (var i = 0; i < usersin.length; i++) {
            button = '<button class="btn btn-success btn-block" data-toggle="modal" data-target="#modal" disabled>' + usersin[i] + '</button>';
            $('#users-in-list').append(button);
        }
    });
}