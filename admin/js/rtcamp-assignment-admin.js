jQuery(
	function ($) {

		window.RTCA = {};

		RTCA.init = function () {
			// Constructor
			RTCA.cacheSelectors();
			RTCA.onLoadEventHandler();
			RTCA.eventHandler();

		}

		RTCA.cacheSelectors = function () {
			// Initialize variables and use in whole script
			RTCA.typingTimer           = 0;
			RTCA.doneTypingInterval    = 500; // Time in milliseconds (0.5 seconds)
			RTCA.document              = $( document );
			RTCA.body                  = $( 'body' );
			RTCA.active                = 'active';
			RTCA.hidden                = 'hidden';
			RTCA.search_results        = RTCA.body.find( '.rtca_contributors_search_output' );
			RTCA.selected_contributors = RTCA.body.find( '.rtca-selected-contributors' );
			RTCA.searchField           = RTCA.body.find( '#rtca_contributors_search_field' );
			RTCA.searchContainer       = RTCA.body.find( '.rtca_contributors_meta_box' );
		}

		RTCA.onLoadEventHandler = function () {

			loadDefaultTrigger();
		}

		RTCA.eventHandler = function () {
			RTCA.body.on( 'input', '.rtca_search', fetchAuthors );
			RTCA.searchField.on( 'click', toggleSearchResultsSection );
			RTCA.document.on( 'click', hideSearchResultsSection );
			RTCA.search_results.on( 'click', stopHidingSearchResultsSection );
			RTCA.body.on( 'change', '.rtca_contributors_search_output input[type="checkbox"]', selectContributors );
			RTCA.body.on( 'click', '.rtca-remove-contributor', removeContributor );

		}

		const loadDefaultTrigger = function (e) {
			fetchAllSelectedContributors( e );
		};

		const removeContributor = function (event) {
			event.preventDefault();
			let btn      = $( this );
			let userID   = btn.attr( 'id' );
			const option = 'remove';

			RTCA.search_results.find( 'li#' + userID + ' input[type="checkbox"]' ).prop( 'checked', false );
			addOrRemoveContributor( userID, option );
		}

		const fetchAllSelectedContributors = function () {
			$.ajax(
				{
					url: '/wp-json/rtca/v1/contributors',
					method: 'GET',
					data: {
						post_id: RTCA_OBJECT.postID,
						_wpnonce: RTCA_OBJECT.nonce
					},
					success: function (response) {

						var template = wp.template( 'rtca-single-author-search-result-template' );

						if (typeof template === 'function') {
							console.log( 'Template function is available.' );
						} else {
							console.error( 'Template function not found.' );
						}

						// Check if the array has at least one object
						var hasContributors = response.some(
							function (item) {
								return typeof item === 'object' && item !== null;
							}
						);

						if (hasContributors) {
							for (let contributor of response) {
								RTCA.selected_contributors.append( template( { result: contributor } ) ); // Display the response
							}
						}

					},
					error: function (xhr, status, error) {
						// $('#result').text('Error: ' + error);
					}
				}
			);
		}
		const fetchAuthors                 = function (event) {

			clearTimeout( RTCA.typingTimer );

			let search_field = $( this );
			let query        = search_field.val();

			// Regular expression to match allowed characters: letters, numbers, spaces, and '@'
			const regex = /^[a-zA-Z0-9 @]*$/;

			if (regex.test( query )) {
				if (query.length < 3) { // User should input at least 3 characters to fire the AJAX
					return false;
				}

				RTCA.typingTimer = setTimeout(
					function () {
						$.ajax(
							{
								url: '/wp-json/rtca/v1/authors',
								method: 'GET',
								data: {
									search: query, // Pass the search term as a query parameter
									post_id: RTCA_OBJECT.postID,
									_wpnonce: RTCA_OBJECT.nonce
								},
								success: function (response) {
									var template = wp.template( 'rtca-authors-search-result-template' );

									if (typeof template === 'function') {
										console.log( 'Template function is available.' );
									} else {
										console.error( 'Template function not found.' );
									}
									/* // Test if template function works with mock data
									var mockData = [
									{
									id: '1',
									name: 'Test User',
									avatar: 'http://example.com/avatar.jpg',
									avatar_2x: 'http://example.com/avatar@2x.jpg'
									}
									];
									 */
									RTCA.search_results.html( template( { results: response } ) ); // Display the response

								},
								error: function (xhr, status, error) {
									RTCA.search_results.html( error );
								}
							}
						);
					},
					RTCA.doneTypingInterval
				);
				console.log( query );
			} else {
				$( this ).val( query.replace( /[^a-zA-Z0-9 @]/g, '' ) );
			}

		};

		// Add to Remove Contributor

		const addOrRemoveContributor = function (userID, option = 'add') {

			let contributorAlreadyExist = RTCA.selected_contributors.find( 'li#' + userID );

			$.ajax(
				{
					url: '/wp-json/rtca/v1/contributor',
					method: 'POST',
					data: {
						trigger: option, // Pass the search term as a query parameter
						user_id: userID,
						post_id: RTCA_OBJECT.postID,
						_wpnonce: RTCA_OBJECT.nonce
					},
					success: function (response) {

						var template = wp.template( 'rtca-single-author-search-result-template' );

						if (typeof template === 'function') {
							console.log( 'Template function is available.' );
						} else {
							console.error( 'Template function not found.' );
						}
						/* // Test if template function works with mock data
						var mockData = [
						{
							id: '1',
							name: 'Test User',
							avatar: 'http://example.com/avatar.jpg',
							avatar_2x: 'http://example.com/avatar@2x.jpg'
						}
						];
						 */
						if (response.success) {
							if (option == 'add') {
								RTCA.selected_contributors.append( template( { result: response.success } ) ); // Display the response
							} else if (option == 'remove') {
								contributorAlreadyExist.remove();
							}

						} else {
							console.log( response.error );
						}

					},
					error: function (xhr, status, error) {
						// $('#result').text('Error: ' + error);
					}
				}
			);
		}
		// Select each contributor on click checkbox

		const selectContributors = function (event) {
			let contributor = $( this );
			let option      = '';
			let userID      = contributor.val();
			if (contributor.is( ":checked" )) {
				option = 'add';
			} else {
				option = 'remove';
			}

			addOrRemoveContributor( userID, option );

		}
		// Prevent clicks inside the search output from hiding it
		const stopHidingSearchResultsSection = function (event) {
			event.stopPropagation();
		}

		// Hide the search output when clicking anywhere outside the search container
		const hideSearchResultsSection = function (event) {
			if ( ! $( event.target ).closest( RTCA.searchContainer ).length) {
				RTCA.search_results.hide();
			}
		}
		// Toggle visibility of the search output when clicking on the search field
		const toggleSearchResultsSection = function (event) {
			event.stopPropagation();
			if (RTCA.search_results.html().trim()) {
				RTCA.search_results.show(); // Show or hide the output
			}

		}

		const hideNotice = (e) => {
			// RTCA.notice.fadeOut('slow');
		};

		RTCA.init();

	}
);