$(document).ready(() => {
    $("#searchForm").on('submit', (e) => {
        e.preventDefault();
        let searchText = $("#searchText").val();
        getMovies(searchText);
    });
});

function getMovies(searchText) {
    //make request to api using axios
    // Make a request for a user with a given ID
    axios.get("https://api.themoviedb.org/3/search/movie?api_key=98325a9d3ed3ec225e41ccc4d360c817&language=en-US&query=" + searchText)
        .then(function (response) {
            let movies = response.data.results;
            let output = '';
            $.each(movies, (index, movie) => {
                output += `
          <div class="col-md-3">
            <div class="well text-center">
              <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}">
              <h5>${movie.title}</h5>
              <a onclick="movieSelected('${movie.id}')" class="btn btn-primary" href="../movie.html">Movie Details</a>
            </div>
          </div>
        `;
            });
            $('#movies').html(output);
        })
        .catch(function (error) {
            console.log(error);
        });
}

function movieSelected(id) {
    sessionStorage.setItem('movieId', id);
    window.location = './movie.html';
    return false;
}

function getMovie() {
    var name = [];
    var character = [];
    var director;
    var musicComposer;
    var length;
    let movieId = sessionStorage.getItem('movieId');
    // Make a request for a user with a given ID
    //add credit to get the credits of the movie 
    //"https://api.themoviedb.org/3/movie/"+movieId+"/credits?api_key=98325a9d3ed3ec225e41ccc4d360c817"
    axios.get("https://api.themoviedb.org/3/movie/" + movieId + "/credits?api_key=98325a9d3ed3ec225e41ccc4d360c817")
        .then(function (response) {
            let credits = response.data;
            console.log(credits);
            length = credits.cast.length; 
            for (var i = 0; i < credits.cast.length; i++)
            {
                name.push(credits.cast[i].name);
                character.push(credits.cast[i].character);
            }
            for (var i = 0; i < credits.crew.length; i++)
            {
                if (credits.crew[i].job == "Director") 
                {
                    director = credits.crew[i].name;
                }
                if (credits.crew[i].job == "Original Music Composer")
                {
                    musicComposer = credits.crew[i].name;
                }
            }

    });

   axios.get("https://api.themoviedb.org/3/movie/" + movieId + "?api_key=98325a9d3ed3ec225e41ccc4d360c817")
        .then(function (response) {
            let movie = response.data;
            console.log(movie);
            let output = `
        <div class="row">
          <div class="col-md-4">
            <img src="https://image.tmdb.org/t/p/w500${movie.poster_path}" class="thumbnail">
          </div>
          <div class="col-md-8">
            <h2>${movie.title}</h2>
            <ul class="list-group">
              <li class="list-group-item"><strong>Genre:</strong> ${movie.genres[0].name}, ${movie.genres[1].name}</li>
              <li class="list-group-item"><strong>Released:</strong> ${movie.release_date}</li>
              <li class="list-group-item"><strong>Rated:</strong> ${movie.vote_average}</li>
              <li class="list-group-item"><strong>Runtime:</strong> ${movie.runtime} min.</li>
              <li class="list-group-item"><strong>Production Companies:</strong> ${movie.production_companies[0].name} min.</li>
            </ul>
          </div>
        </div>
        <div class="row">
          <div class="well">
            <h3>Plot</h3>

            <hr>
            <a href="http://imdb.com/title/${movie.imdb_id}" target="_blank" class="btn btn-primary">View IMDB</a>
            <a href="index.php" class="btn btn-default">Go Back To Search</a>
            <form action="./movie.php" method="post">
            <input type="submit" name="submit" value="Like" style="float:left">
            <input type="submit" name="submit" value="Do Not Suggest" style="float:right">
            <input type="hidden" name="movieID" value="${movie.id}">
            <input type="hidden" name="movieTL" value="${movie.title}">
            <input type="hidden" name="movieGN" value="${movie.genres[0].name}">
            <input type="hidden" name="movieRD" value="${movie.release_date}">
            <input type="hidden" name="movieVA" value="${movie.vote_average}">
            <input type="hidden" name="movieRT" value="${movie.runtime}">
            <input type="hidden" name="moviePC" value="${movie.production_companies[0].name}">
            <input type="hidden" name="director" value="`+ director + `">
            <input type="hidden" name="composer" value="`+ musicComposer +`">
            <input type="hidden" name="numberOfActors" value="`+ length + `">
            </form>
          </div>
        </div>
    `;
            $('#movie').html(output);
        })
        .catch(function (error) {
            console.log(error);
        });
}
