todo move to confluence

title Register Process

ENTER to https://sequencediagram.org/
```
title Register Process

participant User
participant Email Confiramation
participant Nickname & Password
participant Create User


User->Email Confiramation:Enter Email
User<--Email Confiramation:Received Confirm Email Link\n

User->Nickname & Password:Enter Password & User Name Data\n
User<--Nickname & Password:
User->Create User:Send API request for create user

```
