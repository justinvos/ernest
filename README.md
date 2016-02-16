![alt text](http://i.imgur.com/NQWIZVI.png "ernest")


**Ernest** is an open source web application where students can ask and answer questions from their classmates.

## Releases
Ernest is currently under development and is not yet ready for any release builds.

## Licensing
This project is licensed under the GNU GENERAL PUBLIC LICENSE Version 2. The full license can be found in the file "LICENSE" in the repository.

## Values
* Open source licensing means that the project is transparent and that anyone can view or use the source.
* With a modern and simple user interface, students and instructors will be able to use the application right out of the box.
* An expansive API means that other applications can be easily integrated into ernest for even more functionality.

## Roadmap
1. Be able to register a new account. (February 2016)
2. Be able to join a course. (February 2016)
3. Be able to approve applications to join a course. (February 2016)
4. Have an explanation to why a certain answer was correct. (March 2016)
5. Be able to comment on questions. (March 2016)
6. Get points allocated to users based on their activity. (March 2016)
7. Be able to up-vote and down-vote questions on its quality. (March 2016)
8. Be able to attach descriptive tags to questions. (April 2016)

## Config
The config.json file contains all the configuration data for setting up your ernest instance. These variables are required to be set:
* db_address
* db_name
* db_username
* db_password

### Example


`{
  "db_address":"localhost",
  "db_name":"ernest",
  "db_username":"username",
  "db_password":"password123"
}`
