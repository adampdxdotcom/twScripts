jQuery(document).ready(function($) {
    // A delay to ensure all Block Editor and Pods components are loaded.
    setTimeout(function() {

        /* ==========================================================================
           SECTION 1: CREW POD LIVE UPDATE
           ========================================================================== */
        if ($('body').hasClass('post-type-crew')) {
            var crewField = $('[name="pods_meta_crew"]');
            var playContainer = $('.pods-form-ui-row-name-play');

            function updateCrewTitle() {
                var crewValue = crewField.find('option:selected').text().trim();
                var playValue = playContainer.find('.pods-dfv-pick-full-select__single-value').text().trim();
                if (crewField.val() === '') crewValue = '';
                var titleParts = [];
                if (crewValue) titleParts.push(crewValue);
                if (playValue) titleParts.push(playValue);
                var newTitle = titleParts.join(' - ');
                if (newTitle) {
                    wp.data.dispatch('core/editor').editPost({ title: newTitle });
                }
            }
            if (crewField.length > 0) {
                crewField.on('change', updateCrewTitle);
            }
            if (playContainer.length > 0) {
                var observer = new MutationObserver(updateCrewTitle);
                observer.observe(playContainer[0], { childList: true, subtree: true });
            }
        }

        /* ==========================================================================
           SECTION 2: ACTOR POD LIVE UPDATE
           ========================================================================== */
        if ($('body').hasClass('post-type-actor')) {
            var actorNameField = $('#pods-form-ui-pods-meta-actorname');

            function updateActorTitle() {
                var newTitle = actorNameField.val();
                if (newTitle) {
                    wp.data.dispatch('core/editor').editPost({ title: newTitle });
                }
            }
            if (actorNameField.length > 0) {
                actorNameField.on('keyup', updateActorTitle);
            } else {
                console.error('Could not find the actor name field with ID #pods-form-ui-pods-meta-actorname');
            }
        }

        /* ==========================================================================
           SECTION 3: CASTING RECORD POD LIVE UPDATE
           ========================================================================== */
        if ($('body').hasClass('post-type-casting_record')) {
            var characterNameField = $('#pods-form-ui-pods-meta-character-name');

            function updateCastingTitle() {
                var newTitle = characterNameField.val();
                if (newTitle) {
                    wp.data.dispatch('core/editor').editPost({ title: newTitle });
                }
            }
            if (characterNameField.length > 0) {
                characterNameField.on('keyup', updateCastingTitle);
            } else {
                console.error('Could not find the character name field with ID #pods-form-ui-pods-meta-character-name');
            }
        }

        /* ==========================================================================
           SECTION 4: BOARD TERM POD LIVE UPDATE (FINAL VERSION)
           ========================================================================== */
        if ($('body').hasClass('post-type-board_term')) {
            var fieldsContainer = $('#pods-meta-more-fields');
            var positionField = $('#pods-form-ui-pods-meta-board-position');
            var startDateField = $('#pods-form-ui-pods-meta-start-date');
            var endDateField = $('#pods-form-ui-pods-meta-end-date');

            function updateBoardTermTitle() {
                var positionValue = positionField.find('option:selected').text();
                var startDateValue = startDateField.val();
                var endDateValue = endDateField.val();

                if (positionField.val() && startDateValue && endDateValue) {
                    var startYear = startDateValue.split('-')[0];
                    var endYear = endDateValue.split('-')[0];

                    var newTitle = positionValue + ' ' + startYear + '-' + endYear;
                    wp.data.dispatch('core/editor').editPost({ title: newTitle });
                }
            }
            
            if (fieldsContainer.length > 0) {
                var observer = new MutationObserver(updateBoardTermTitle);
                observer.observe(fieldsContainer[0], {
                    childList: true,
                    subtree: true,
                    attributes: true,
                    characterData: true
                });
            } else {
                console.error('Board Term Error: Could not find the main fields container #pods-meta-more-fields');
            }
        }

        /* ==========================================================================
           SECTION 5: LOCATION POD LIVE UPDATE (BLOCK EDITOR COMPATIBLE)
           ========================================================================== */
        if ($('body').hasClass('post-type-location')) {
            
            console.log('Location Pod script is running.'); // For debugging

            // This selector targets the input field by its unique 'name' attribute,
            // which is more reliable in the Block Editor than the ID.
            var locationFieldSelector = 'input[name="pods_meta_location_name"]';

            // Use a delegated event listener attached to the document body.
            // This is the most robust way to handle fields loaded by React (the Block Editor).
            $(document.body).on('keyup change paste', locationFieldSelector, function() {
                
                var newTitle = $(this).val();

                if (newTitle) {
                    wp.data.dispatch('core/editor').editPost({ title: newTitle });
                }
            });
        }
		
        /* ==========================================================================
           SECTION 6: EVENT POD LIVE UPDATE (NEWLY ADDED)
           ========================================================================== */
        if ($('body').hasClass('post-type-event')) {
            
            // Selector for the 'event_name' input field.
            // Targeting by the 'name' attribute is reliable in the Block Editor.
            var eventNameFieldSelector = 'input[name="pods_meta_event_name"]';

            // Use a delegated event listener attached to the document body. This method
            // works reliably even when the Block Editor re-renders its components.
            $(document.body).on('keyup change paste', eventNameFieldSelector, function() {
                
                var newTitle = $(this).val();

                if (newTitle) {
                    // This is the standard Gutenberg way to update the post title.
                    wp.data.dispatch('core/editor').editPost({ title: newTitle });
                }
            });
        }

    }, 2000);
});
