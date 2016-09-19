create table Movie(
	id int not null,   /*every movie must have an id*/
	title varchar(100) not null,  /*every movie must have a title*/
	year int,
	rating varchar(10),
	company varchar(50),
	primary key(id)  /*every movie has a unique id*/
)ENGINE = INNODB;

create table Actor(
	id int not null,   /*every actor must have an id*/
	last varchar(20) not null,  /*every actor must have a last name*/
	first varchar(20) not null, /*every actor must have a first name*/
	sex varchar(6) not null,  /*every actor must have a sex*/
	dob date not null,  /*every actor must have a date of birth*/
	dod date,
	primary key(id),		/*every actor has a unique id*/
	CHECK(sex in ('Male','Female')), /* the sex of actor must be 'Male' or 'Female' */
	CHECK(dob<date_format(curdate(),'%Y%m%d'))
	/*The actor's date of birth should earlier than current date.*/
)ENGINE = INNODB;

create table Sales(
	mid int not null,  /*primary key cannot be null*/
	ticketsSold int,
	totalIncome int,
	primary key(mid),	/*movie id must be unique*/
	foreign key (mid) references Movie(id)  /*movie id must be in movie table*/
)ENGINE = INNODB;

create table Director(
	id int not null,  /*every director must have an id*/
	last varchar(20) not null, /*every director must have a last name*/
	first varchar(20) not null, /*every directtor must have a first name*/
	dob date not null,  /*every director must have a date of birth*/
	dod date,
	primary key(id),   /*every director has a unique id*/
	CHECK(dob<date_format(curdate(),'%Y%m%d'))
	/*The director's date of birth should earlier than current date.*/
)ENGINE INNODB;

create table MovieGenre(
	mid int not null,  /*primary key cannot be null*/
	genre varchar(20) not null,  /*every movie must have a genre*/
	primary key(mid),  /*movie id must be unique*/
	foreign key(mid) references Movie(id)  /*movie id must be in movie table*/
)ENGINE INNODB;

create table MovieDirector(
	mid int not null,   /*movie id cannot be null*/
	did int not null,   /*director id cannot be null*/ 
	foreign key(mid) references Movie(id), /*movie id must be in movie table*/
	foreign key(did) references Director(id)  /*director id must be in director table*/
)ENGINE INNODB;

create table MovieActor(
	mid int not null,  /*movie id cannot be null*/
	aid int not null,  /*actor id cannot be null*/
	role varchar(50),
	foreign key(mid) references Movie(id), /*movie id must be in movie table*/
	foreign key(aid) references Actor(id)  /*actor id must be in actor table*/
)ENGINE INNODB;

create table MovieRating(
	mid int not null,  /*movie id cannot be null*/
	imdb int,
	rot int,
	primary key(mid),
	foreign key(mid) references Movie(id) /*movie id must be in movie table*/
)ENGINE INNODB;

create table Review(
	name varchar(20),
	time timestamp,
	mid int not null,  /*movie id cannot be null*/
	rating int,
	comment varchar(500),
	foreign key(mid) references Movie(id), /*movie id must be in movie table*/
	CHECK(rating >= 0 and rating <= 5) /* the rating must be at the range of 0-5 */
)ENGINE INNODB;

create table MaxPersonID(
	id INT
)ENGINE INNODB;

create table MaxMovieID(
	id int
)ENGINE INNODB;














