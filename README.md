
INSTALLATION
------------


### Install with Git

Git Clone ''


CONFIGURATION
-------------

### Database

You will find a file named `job_board.sql`
import it into your mysql using php myadmin or any other tool 


Edit the file `config/db.php` with real data, for example:

```php
return [
    'class' => 'yii\db\Connection',
    'dsn' => 'mysql:host=localhost;dbname=job_board',
    'username' => 'your user name',
    'password' => 'your password',
    'charset' => 'utf8',
];
```

End Points
-------

1- user/signup'

    method : POST
    
    body as form data :
        -name
        -email
        -password
        -type : 1 for recuriter 2 for seeker

2- user/signin'
    method : POST
    body as form data :
        -email
        -password
        
3- job/create
    method : POST
    headers : 
        - barear token that back from signin | sign up 
    body as form data : 
        - title 
        - description
    notes : 
        only recruiter can create job

 4- jobs
     method : GET
     headers : 
        - barear token that back from signin | sign up
     return :
      return all Jobs 

 5- jobs/1
     method : GET
     headers : 
        - barear token that back from signin | sign up
     return :
      return job with job id number 1

 6- job/application/1
     method : GET
     headers : 
        - barear token that back from signin | sign up
     return :
      return all job applications for job id number 1 only for the authorized users (the recruter that created the job)
     notes:
        only recruiter can create job
        
  7- job/apply/1
     method : POST
     headers : 
        - barear token that back from signin | sign up
     return :
      Apply for job id nubber 1 only if it exist 
     notes:
        only Seeker can Apply For a job

  8- job/my-applications 
      method : GET
       headers : 
        - barear token that back from signin | sign up
       return :
           return all application applied by the seeker 
     notes:
        only Seeker can use this end point

