# This event will create clock out records in the logs table to kick out the users that didnt clock out manually. The clock out record is flagged for supervisor purposes.
CREATE EVENT kick_out_employees
    ON SCHEDULE
		EVERY 1 DAY STARTS '2018-04-27 23:55:59'
    DO 
      INSERT INTO clockinout.logs (eId, time, inorout, name, flag) SELECT id, CURRENT_TIMESTAMP(), '0', name, '1' FROM clockinout.employees WHERE inorout = 1;