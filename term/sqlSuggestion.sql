use ISP_dtl29;
(SELECT Movies.Title, Genres.Genre FROM Movies JOIN Genres)AS B FROM B JOIN 
	(SELECT Genre, Titles FROM 
		(SELECT Likeddtl29.titles, Actors.Name, Genres.Genre  FROM Likeddtl29 JOIN Genres ON Likeddtl29.titles = Genres.Title JOIN Actors ON Likeddtl29.titles = Actors.Title) 
AS G GROUP BY Genre ORDER BY COUNT(*) DESC LIMIT 1)AS M ON B.Genres = M.Genre; 

	

