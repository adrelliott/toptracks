<?php

it('clears the sessions after 59 minutes');

it('encrpyts the access token in the session');

test('the refresh token is encypted in the database');

it('can refresh the access token when none is found in the session');

it('can handle a token not valid exception');

/** Methods */

test('getCurrentTrack returns current playing tracks');
test('getProfile returns spotify profile of logged in user');
test('getPLayloists returns paginated results of users playlists');