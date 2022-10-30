<?php

// ================================================== SELECT ==================================================

// Searching songs by song name
function searchSongByName($name) {

}

// Searching songs by artist name and song name
function searchSongsByNameAndArtist($aName, $sName) {

}

// Searching Artists by name
function searchArtistByName($name) {

}

// Searching Albums by album name and artist name
function searchAlbumByNameAndArtist($album, $artist) {

}

// Displaying the ratings on a song
function displayRatings($id) {

}

// Get a song’s average rating
function getSongAvgRating($id) {

}

// Get average song rating for each artist
function getArtistsAvgRating() {

}

// Get average song rating for each album
function getAlbumsAvgRating() {

}

// Get all albums that a song is on given songID
function searchAlbumBySong($sid) {

}

// Get details of a song
function songDetails($id) {

}

// Get User Data
function getUserData($id) {

}

// Get all of a given user’s ratings
function getUsersRatings($id) {

}

// ================================================== ADD ==================================================

// Add rating given ratingID, songID, userID, and rating information
function addRating($rid, $sid, $uid, $rhythm, $melody, $atmosphere, $general, $desc) {

}

// Add User
function addUser($uid, $name, $email, $date) {

}

// Add Song given id, duration, songName, artistID, and albumID
function addSong($id, $dur, $name, $artid, $albid ) {

}

// Add artist and album left up to the admin for now

// ================================================== UPDATE ==================================================

// Edit Rating
function editRating($rid, $rhythm, $melody, $atmosphere, $general, $desc) {

}

// Edit average rating for a song given songID
function editSongAvgRating($id, $rating) {

}

// Edit average rating for an artist given artistID
function editArtistAvgRating($id, $rating) {

}

// Edit average rating for an album given albumID
function editAlbumAvgRating($id, $rating) {

}

// ================================================== DELETE ==================================================

// Delete Rating given ratingID
function deleteRating($id) {

}

// Delete User given userID
function deleteUser($id) {

}
?>