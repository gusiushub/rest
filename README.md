
**Установка**

`git clone https://github.com/gusiushub/rest.git `

`composer update`

**Конфигурации** <hr>
config/config.php - основные настройки
config/db.php - настройки бд
damp/*** - дамп бд 
<br>

**Консольное приложение** <hr>

console.php - _консольные команды_ <br>
Для взаимодействия с console.php требуется перейти в директорию, в которой находится файл.<br>
Для этого в терминале <br>

`cd /var/www/yourfolder     (134.209.88.94)`

директория с изображениями - incoming (/var/www/***/incoming) <br>

Команда для запуск консольного приложения, которое правит имена файлов в папке Male <br>

`php console.php rename Male`

Команда для запуск консольного приложения, которое правит имена файлов в папке Female <br>

`php console.php rename Female` 

**Запросы к API** <hr>

Дефолтные параметры:
    token
    action  - выбор типа запроса


**Доступ к логу** <br>

`/?action=log&token=li2j3fojewf`
<br>
app/log/log.log - файл для записи логов


**Доступ к аватару пользователя** 

Требуются параметры:  <br>
    login <br>
   
`/?action=showpic&login=yourlogin&token=li2j3fojewf`


**Доступ к портам (IP)** <br>

`/?action=ip&token=li2j3fojewf`


**Добавить пользователя** <br>

Требуются параметры:  <br>
    login - уникальный  <br>
    fullname  <br>
    country  <br>
    age  <br>
    ip  <br>
    79857916258  - 11=< знаков , без +   <br>
    ip   <br>
    password  <br>
    sex   0 - M; 1 - Ж  <br>
     
`/?action=add&login=yourlogin&token=li2j3fojewf&fullname=James%20Dillard&phone=79857916258&country=Russia&sex=1&age=25&ip=24014&password=be705ae609ed`


**Смена статуса**  <br>

Требуются параметры:  <br>
    login <br>
    newstatus  -  ваш новый статус    <br>
    
    
`/?action=setstatus&login=yourlogin&token=li2j3fojewf&newstatus=1`

**Доступ к Bio**  <br>
Требуются параметры:  <br>
    login  <br>
    
    
`/?action=bio&login=yourlogin&token=li2j3fojewf`
<br>
bio.txt - файл для хранения bio юзера <br>
<br>
заполнять =>  <br>
<br>

---         <br>

textbio   <br>

---  <br>

**Отправить аватар**  <br>
Требуются параметры:  <br>
    login   <br>
    status - отправить если ok <br>
    
    
/?action=avatar&login=yourlogin&token=li2j3fojewf&status=ok



_____________________________________________________________

/?action=useridbylogin&login=yourlogin&token=li2j3fojewf

/?action=postcount&login=yourlogin&token=li2j3fojewf

/?action=userbystatus&status=1&token=li2j3fojewf





