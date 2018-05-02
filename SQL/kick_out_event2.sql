# This event will update the status of the employees that didnt clock out manually. 
# This event must be run after the event 'kick_out_employees'.
CREATE EVENT kick_out_employees2
    ON SCHEDULE
		EVERY 1 DAY STARTS '2018-04-27 23:56:59'
    DO 
      UPDATE clockinout.employees SET inorout = 0 WHERE ID IN (SELECT ID FROM (SELECT * FROM clockinout.employees) AS temp WHERE inorout = 1);