# BLFC Volunteer Shift Tracker System
Tracker is an at-con time clock system for volunteers at [BLFC](https://goblfc.org).
Volunteers can clock in and clock out for their shifts to log their hours, ensuring they get the rewards they deserve.
Staff can manage volunteers, their time and rewards, and run various reports.

## Features
Tracker is an evolving system and has many planned features and improvements on their way, but here is a
semi-comprehensive list of the current features implemented.

- Log in with ConCat or quick sign-in codes generated by the Telegram bot
- Volunteers check in and out for department shifts on authorized kiosks only
- Staff check in and out from kiosks or their own devices
- Time bonuses (multiplies earned volunteer time during a certain period for specific departments)
- Automatic shift closing at end of day
	* Catches forgotten checkouts
	* Credits only 1hr
	* Notifies to visit the volunteer desk to get corrected
- Manager dashboard
	* List of recent check-ins/outs
	* List of longest ongoing shifts
	* Volunteer search
	* Volunteer time viewing/editing
	* Reward claiming
- Attendee logs
	* Appoint any volunteer to be a gatekeeper (able to log attendees)
	* Quick & painless logging of attendees as they enter the door
	* Basic support for barcode scanners (for scanning badges)
- Reporting
	* Volunteer hours
	* Department summary (hours, volunteer count, shifts)
	* Unclocked users (volunteers that got automatically checked out at the end of a day)
	* Volunteer applications (ConCat report, displays all volunteer applications in a more convenient table)
	* Application department summary (ConCat report, totals the assigned volunteers and desired hours per department)
	* Audit logs (all actions within Tracker are logged)
- Alerts/notifications (when signing in and via Telegram)
	* Reward available
	* Reward claimed
	* Forgot to check out after a shift
- ConCat integration
	* Authentication (for both volunteers and staff)
	* Volunteer reports
	* Automatic logout for kiosks
- Telegram integration
	* Quick sign in codes
	* Time/shift/reward status
	* Notifications

## Documentation
All information is housed in the [project wiki](https://github.com/GoBLFC/Tracker/wiki).
Here are some quick links:

- [Setting up with Docker](https://github.com/GoBLFC/Tracker/wiki/Setup-(Docker))
- [Setting up manually](https://github.com/GoBLFC/Tracker/wiki/Setup-(Manual))
- [Development setup](https://github.com/GoBLFC/Tracker/wiki/Development)
- [Architecture/detailed info](https://github.com/GoBLFC/Tracker/wiki/Architecture)