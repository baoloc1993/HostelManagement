# HostelManagement
This is the web application which is used for manage the hostel. The functions of the application:
# 1.  Create/Edit the booking. 
  The staff/admin can input the information of the customer such as name, birthday, identity number... Moreover, they can upload the image of the customer or the identity card for further use. Beside, they can select the staying period of the customer and the amount of the deposit.
# 2. View the rooms and statuses
  The staff/admin can view the list of the room/bed and their status. There are 3 statuses of a room
  -   <b>Available (Green Color)</b> :  The room is unoccupied and the staff/admin can select this room when booking for the customer
  -   <b>Reserved (Yellow Color)</b> : The room is reserved and the staff/admin cannot select this room when booking for the customer. 
  -   <b>Not Available (Red Color)</b> : The room is occupied and the staff/admin cannot select this room when booking for the customer.
  When user click to each room. The user can view the detail of the booking.
  The status of a room will automatically become <b>Available</b> when the living period ended without extending.
# 3. View the detail of the booking
The staff/admin can view the detail of the booking by clicking to each room in the list. If the room is <b>Available</b>, there is no information. If the room is <b> Reserved </b>, the user will see the date of booking, the information of the customer and the time when the customer come. If the room is <b> Not Available </b>, the user will see the full information of the booking such as the information of the customer, the services of the customer is using or the period of the booking.
# 4. Add/Edit/Remove the service. 
  The staff/admin can add the add-on service for customer like rental fee,renting bike, dinner, breakfast or coffee... The <b>admin</b> can add/remove/edit the service in the list and change the price of each service.
  The user can view the services of the customer used with their date, type and price. Besides, the customer can know how much the customer paid or the total price of all services.
# 5. Check out / Switch room
  When the customer wants to <b>checkout</b>, the user clicks to the <b>Check out</b> button and the system will generate the report for the customer.
  When the customer wants to <b> switch room</b>, the user clicks to the <b> Switch Room </b> button and all the information of this booking will be changed to another room. Besides, the status of each room will be changed in the list.
# 6. History
  The admin can search the history of the booking by some filters:
  - The name/address/identication number of the customer  
  - The date range of the booking
  - The room number.
  After search the history, the list of booking will be displayed and the user can click to each booking to view the detail of the booking.
# 7. Report
  The admin can view the report of all services includes the rental fee and deposit. The user can select the range of the date and the service they want to view and generate the report.
  If admin can export the report to the excel file or pdf file.
# 8. List of customers
  The admin can view the list of images of customers. The images will be displayed in grid. When click/touch to the image, the information of that customer such as room number and name will be popup.
