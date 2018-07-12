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
            j++;
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
                tooltips: {
                    enabled: false
                },
                hover: {
                    mode: null
                },
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
    positions = { 1: 0, 2: 0, 3: 0, 4: 0, 5: 0, 6: 0, 7: 1, 8: 2, 9: 3, 10: 4, 11: 5, 12: 6, 13: 7, 14: 8, 15: 9, 16: 10, 17: 11, 18: 12, 19: 12, 20: 12, 21: 12, 22: 12, 23: 12, 24: 12 };
    var d = new Date();
    var n = d.getHours();

    $('#users-in tbody tr').remove();
    $('#users-names tbody tr').remove();
    $('#users-numbers tbody tr').remove();
    $.getJSON("backend/public/api/usersLogs", function (usersin) {
        for (var i = 0; i < usersin.length; i++) {
            button = '';
            row = '<tr>';
            placed = 0;
            $timezone_offset = 0;
            namerow = '';
            enumbers = "";
            todayTotalHours = 0;
            today = new Date();
            todayYMD = today.getFullYear() + '-' + (today.getMonth() + 1) + '-' + today.getDate();
            for (var j = 4; j < (usersin[i].length); j++) {
                td = '';
                employe_status_class = '';
                // start position of the current entry
                displacement = positions[parseInt(usersin[i][j].substr(0, 2)) - $timezone_offset];
                // end position of the current entry
                odd = false;
                if ((j + 2) >= usersin[i].length) {
                    // Calculate hours worked today
                    currDate = new Date(todayYMD + ' ' + usersin[i][j]);
                    todayTotalHours += (today - currDate) / 3600000;
                    // Change odd to true
                    odd = true;
                    // 
                    nextDisplacement = positions[n];
                    button = '<button class="btn btn-primary btn-block employee-log employee-in" data-toggle="modal" data-target="#modal" data-id="' + usersin[i][0] + '"><span class="float-left">' + (usersin[i][j]).substring(0, 5); + '</span></button>';
                    employe_status_class = 'employee-in';
                } else {
                    // Calculate hours worked today
                    currDate = new Date(todayYMD + ' ' + usersin[i][j]);
                    nextDate = new Date(todayYMD + ' ' + usersin[i][j+1]);
                    todayTotalHours += (nextDate - currDate) / 3600000;
                    //console.log(usersin[i][j+2]);
                    nextDisplacement = positions[parseInt(usersin[i][j + 1].substr(0, 2)) - $timezone_offset];
                    button = '<button class="btn btn-warning btn-block employee-log employee-out" data-toggle="modal" data-target="#modal" data-id="' + usersin[i][0] + '"><span class="float-left">' + (usersin[i][j]).substring(0, 5) + '</span> - <span class="float-right">'+ (usersin[i][j + 1]).substring(0, 5) +'</span></button>';
                    employe_status_class = 'employee-out';
                }

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
                        td = '<td colspan="' + (displacement - placed) + '"><button class="btn btn-default btn-block" disabled>-</button></td>';
                    }
                    td = td + '<td colspan="' + (nextDisplacement - displacement + 1) + '">';
                    td = td + button;
                    td = td + '</td>';
                    placed = placed + nextDisplacement + 1;
                    row = row + td;
                    j++;
                }

                if(usersin[i][3]){
                    //console.log(usersin[i][1] + " is exterior");
                    namerow = '<tr><td><button class="btn btn-primary btn-block employee-log '+ employe_status_class +'" data-toggle="modal" data-target="#modal" data-id="' + usersin[i][0] + '"><i class="fas fa-stroopwafel"></i> ' + usersin[i][1] + ': ' + (todayTotalHours + '').substring(0,3) + '</button></td></tr>';
                }
                else{
                    //console.log(usersin[i][1] + " is not exterior");
                    namerow = '<tr><td><button class="btn btn-primary btn-block employee-log '+ employe_status_class +'" data-toggle="modal" data-target="#modal" data-id="' + usersin[i][0] + '">' + usersin[i][1] + ': ' + (todayTotalHours + '').substring(0,3) + '</button></td></tr>';
                }

                if(usersin[i][2]){
                    enumbers = '<tr><td><button class="btn btn-block employee-log" style="overflow: hidden;">'+usersin[i][2]+'</button></td></tr>';
                }
                else{
                    enumbers = '<tr><td><button class="btn btn-block employee-log">&nbsp;</button></td></tr>';
                }
            }
            $('#users-names tbody').append(namerow);
            $('#users-numbers tbody').append(enumbers);
            row = row + '</tr>';
            $('#users-in tbody').append(row);
        }
    });
}

function loadUsers() {
    $('#users-out-list').html('');
    $('#users-in-list').html('');
    $.getJSON("backend/public/api/employeesOut", function (usersout) {
        $('#users-out-count').html(usersout.length);
        for (var i = 0; i < usersout.length; i++) {
            button = '<button class="btn btn-warning employee-log employee-out mr-1 mb-1" data-toggle="modal" data-target="#modal" data-id="' + usersout[i]['id'] + '">' + usersout[i]['name'] + '</button>';
            $('#users-out-list').append(button)
        }
    });
    $.getJSON("backend/public/api/employeesIn", function (usersin) {
        $('#users-in-count').html(usersin.length);
        for (var i = 0; i < usersin.length; i++) {
            button = '<button class="btn btn-success employee-log employee-in mr-1 mb-1" data-toggle="modal" data-target="#modal" data-id="' + usersin[i]['id'] + '">' + usersin[i]['name'] + '</button>';
            $('#users-in-list').append(button);
        }
    });
}