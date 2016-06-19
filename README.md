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
**July 2016** - Core functionality complete and an online trial website.  
**August 2016** - Supporting functionality complete.  
**September 2016** - Tagging, searching and scoring complete.  
**October 2016** - Stable and beta release.

### Upcoming features
#### CORE
* Answer creation
* Answer deletion
* Answer editing
* Correct answer selection
* Account registration
* Login

#### SUPPORTING
* Course creation
* Answer explanations
* Password recovery
* Email verification

#### EXTRA
* Scoring system
* Up-voting and down-voting questions
* Searchable tags for questions
* Moderators
* Applications to join a course
* Commenting
* Sortable listing of questions
* Leaderboards
* Achievements

## Config
The config.json file contains all the configuration data for setting up your ernest instance. These variables are required to be set:
* db_address
* db_name
* db_username
* db_password

### Example


```
{  
  "db_address":"localhost",  
  "db_name":"ernest",  
  "db_username":"username",  
  "db_password":"password123"  
}
```
