<?php

// ================================================== SELECT ==================================================

// Searching songs by song name
function searchSongByName($name) {
    global $db

    $query = 'SELECT songs.songName, artists.artistName, songs.avgRating 
    FROM songs, songreleasedby, artists
    WHERE songName LIKE "%:name%"
    AND songs.id = songreleasedby.songID
    AND songreleasedby.artistID = artists.id
    ORDER BY songs.avgRating DESC'

    $statement = $db->prepare($query);
    $statement->bindValue(':name', $name);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Searching songs by artist name and song name
function searchSongsByNameAndArtist($aName, $sName) {
    global $db

    $query = 'SELECT songs.songName, artists.artistName, songs.avgRating 
    FROM songs, songreleasedby, artists
    WHERE songName LIKE "%:sName%"
    AND artistName LIKE "%:aName%"
    AND songs.id = songreleasedby.songID
    AND songreleasedby.artistID = artists.id'

    $statement = $db->prepare($query);
    $statement->bindValue(':aName', $aName);
    $statement->bindValue(':sName', $sName)
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;

}

// Searching Artists by name
function searchArtistByName($name) {
    global $db

    $query = 'SELECT artistName, avgSongRating 
    FROM artists	
    WHERE artistName LIKE "%:name%"
    ORDER BY avgSongRating DESC'

    $statement = $db->prepare($query);
    $statement->bindValue(':name', $aName);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;

}

// Searching Albums by album name and artist name
function searchAlbumByNameAndArtist($album, $artist) {
    global $db

    $query = 'SELECT albums.albumName, artists.artistName, albums.avgSongRating, albums.releaseDate 
    FROM albums, artists, albumReleasedBy
    WHERE albums.albumName LIKE "%:album%"
    AND artists.artistName LIKE "%:artist%"
    AND albums.id = albumReleasedBy.albumID
    AND artists.id = albumReleasedBY.artistID
    ORDER BY albums.avgSongRating DESC'

    $statement = $db->prepare($query);
    $statement->bindValue(':album', $album);
    $statement->bindValue(':artist', $artist);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Displaying the ratings on a song
function displayRatings($id) {
    global $db

    $query = 'SELECT ratings.rhythm, ratings.melody, ratings.atmosphere, ratings.description, idToUsername.userName
	FROM ratings, rated, submits, idToUsername
	WHERE rated.ratingID = rating.ID 
    AND rated.songID = :id
	AND ratings.ID = submits.ratingID
	AND submits.userID = idToUsername.id'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Get a song’s average rating
function getSongAvgRating($id) {
    global $db

    $query = 'SELECT AVG(ratings.generalRating)
    FROM songs, ratings, rated
    WHERE songs.id = :id
    AND rated.songID = songs.id
    AND rated.ratingID = ratings.id
    AND ratings.generalRating >= 0'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Get average song rating for each artist
function getArtistsAvgRating() {
    global $db

    $query = 'SELECT artists.id, AVG(songs.avgRating)
    FROM artists, songReleasedBy, songs
    WHERE songReleasedBy.artistID = artists.id
    AND songReleasedBy.songID = songs.id
    AND songs.avgRating >= 0
    GROUP BY artists.id'

    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Get average song rating for each album
function getAlbumsAvgRating() {
    global $db

    $query = 'SELECT albums.id, AVG(songs.avgRating)
    FROM albums, onAlbum, songs
    WHERE songs.id = onAlbum.songID
    AND albums.id = onAlbum.albumID
    AND songs.avgRating >= 0
    GROUP BY albums.id'

    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Get all albums that a song is on given songID
function searchAlbumBySong($id) {
    global $db

    $query = 'SELECT albums.id
    FROM albums, onAlbum
    WHERE onAlbum.albumID = albums.id
    AND onAlbum.songID = :id'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Get details of a song
function songDetails($id) {
    global $db

    $query = 'SELECT albums.id
    FROM albums, onAlbum
    WHERE onAlbum.albumID = albums.id
    AND onAlbum.songID = :id'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Get User Data
function getUserData($id) {
    global $db

    $query = 'SELECT userName, email, dateJoined
    FROM idToUsername NATURAL JOIN idToInfo
    WHERE id = :id'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Get all of a given user’s ratings
function getUsersRatings($id) {
    global $db

    $query = 'SELECT idToUsername.userName, ratings.rhythm, ratings.melody, ratings.atmosphere, ratings.generalRating, ratings.description, songs.songName, songs.duration, songs.avgRating, artists.artistName
    FROM ratings, rated, idToUsername, songs, submits, songReleasedBy, artists
    WHERE submits.userID = :id
    AND idToUsername.id = :id
    AND ratings.id = submits.ratingID
    AND rated.ratingID = submits.ratingID
    AND songs.ID = rated.ratingID
    AND songReleasedBy.songID = songs.id
    AND artists.id = songReleasedBy.artistID'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}

// Get the most highly rated 5 (or so songs)
function getTopSongs() {
    global $db

    $query = 'SELECT songs.songName, songs.avgRating, songs.duration, artists.artistName
    FROM songs, songReleasedBy, artists
    WHERE songs.id = songReleasedBy.songID
    AND songReleasedBy.artistID = artists.id
    ORDER BY songs.avgRating DESC
    LIMIT 5'

    $statement = $db->prepare($query);
    $statement->execute();
    $result = $statement->fetchAll();
    $statement->closeCursor();
    return $result;
}
// ================================================== ADD ==================================================

// Add rating given ratingID, songID, userID, and rating information
function addRating($rid, $sid, $uid, $rhythm, $melody, $atmosphere, $general, $desc) {
    global $db

    $query = 'INSERT INTO ratings(id, rhythm, melody, atmosphere, generalRating, description)
    VALUES (:rid, :rhythm, :melody, :atmosphere, :general, :desc);
    INSERT INTO rated(ratingID, songID) VALUES (:rid, :sid);
    INSERT INTO submits(userID, ratingID) VALUES (:uid, :rid);'

    $statement = $db->prepare($query);
    $statement->bindValue(':rid', $rid);
    $statement->bindValue(':sid', $isd);
    $statement->bindValue(':uid', $uid);
    $statement->bindValue(':rhythm', $rhythm);
    $statement->bindValue(':melody', $melody);
    $statement->bindValue(':atmosphere', $atmosphere);
    $statement->bindValue(':general', $general);
    $statement->bindValue(':desc', $desc);
    $statement->execute();
    $statement->closeCursor();
}

// Add User
function addUser($uid, $name, $email, $date) {
    global $db

    $query = 'INSERT INTO idToUsername(id, userName) VALUES (:uid, :name);
    INSERT INTO idToInfo(id, email, dateJoined) VALUES (:uid, :email, :date);'

    $statement = $db->prepare($query);
    $statement->bindValue(':uid', $uid);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':email', $email);
    $statement->bindValue(':date', $date);
    $statement->execute();
    $statement->closeCursor();
}

// Add Song given id, duration, songName, artistID, and albumID
function addSong($id, $dur, $name, $artid, $albid ) {
    global $db

    $query = 'INSERT INTO songs(id, duration,avgRating, songName) VALUES (:id, :dur, NULL, :name );
    INSERT INTO songReleasedBy(songID, artistID) VALUES (:id, :artid);
    INSERT INTO onAlbum(songID, albumID) VALUES (:id, :albid);'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':dur', $dur);
    $statement->bindValue(':name', $name);
    $statement->bindValue(':artid', $artid);
    $statement->bindValue(':albid', $albid);
    $statement->execute();
    $statement->closeCursor();
}

// Add artist and album left up to the admin for now

// ================================================== UPDATE ==================================================

// Edit Rating
function editRating($id, $rhythm, $melody, $atmosphere, $general, $desc) {
    global $db

    $query = 'UPDATE ratings SET rhythm=:rhythm, melody=:melody, atmosphere=:atmosphere, generalRating=:general, description=:desc
    WHERE id=:id'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':rhythm', $rhythm);
    $statement->bindValue(':melody', $melody);
    $statement->bindValue(':atmosphere', $atmosphere);
    $statement->bindValue(':general', $general);
    $statement->bindValue(':desc', $desc);
    $statement->execute();
    $statement->closeCursor();
}

// Edit average rating for a song given songID
function editSongAvgRating($id, $rating) {
    global $db

    $query = 'UPDATE songs SET avgRating = :rating WHERE id = :id'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':rating', $rating);
    $statement->execute();
    $statement->closeCursor();
}

// Edit average rating for an artist given artistID
function editArtistAvgRating($id, $rating) {
    global $db

    $query = 'UPDATE artist SET avgSongRating = :rating WHERE id = :id'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':rating', $rating);
    $statement->execute();
    $statement->closeCursor();
}

// Edit average rating for an album given albumID
function editAlbumAvgRating($id, $rating) {
    global $db

    $query = 'UPDATE album SET avgSongRating = :rating WHERE id = :id'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->bindValue(':rating', $rating);
    $statement->execute();
    $statement->closeCursor();
}

// ================================================== DELETE ==================================================

// Delete Rating given ratingID
function deleteRating($id) {
    global $db

    $query = 'DELETE FROM ratings WHERE id = :id;
    DELETE FROM rated WHERE ratingID = :id;
    DELETE FROM submits WHERE ratingID = :id;'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();
}

// Delete User given userID
function deleteUser($id) {
    global $db

    $query = 'DELETE FROM idToUsername WHERE id = :id;
    DELETE FROM idToInfo WHERE id = :id;'

    $statement = $db->prepare($query);
    $statement->bindValue(':id', $id);
    $statement->execute();
    $statement->closeCursor();
}
?>