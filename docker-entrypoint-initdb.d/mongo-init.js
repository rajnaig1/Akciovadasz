print("Starting Database");
/*db=db.getSiblingDB('Shopping');
db.createUser(
{
user: 'Fonok',
pwd: 'Kutyamacska',
roles: [{role: 'readWrite', db:'Shopping'}]
}
);*/
db=db.getSiblingDB('TestShopping');
db.createUser(
{
user: 'root',
pwd: 'testteknos',
roles: [{role: 'root', db:'TestShopping'}]
}
);
print('Ending Database');
