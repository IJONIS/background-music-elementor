/**
 * Background Music for Elementor
 * Frontend JavaScript
 */
(function($) {
    'use strict';

    // Initialize when document is ready
    $(document).ready(function() {
        // Find all background music instances
        var audioElements = $('.bme-audio-element');
        
        if (audioElements.length) {
            // Setup each audio instance
            audioElements.each(function(index) {
                var audioElement = $(this);
                var widgetId = 'bme-widget-' + index;
                var audioId = 'bme-audio-' + index;
                
                // Set unique IDs for multiple instances
                audioElement.attr('id', audioId);
                
                // Find the widget container related to this audio element
                var widgetContainer = audioElement.prev('.bme-audio-widget');
                if (widgetContainer.length) {
                    widgetContainer.attr('id', widgetId);
                    setupAudioControls(audioId, widgetId, index);
                } else {
                    // Handle audio without visible controls
                    setupBackgroundAudio(audioId);
                }
            });
        }
    });

    /**
     * Setup audio controls for visible player
     */
    function setupAudioControls(audioId, widgetId, index) {
        var audio = document.getElementById(audioId);
        var widget = $('#' + widgetId);
        var playPauseBtn = widget.find('.bme-play-pause-btn');
        var playIcon = widget.find('.bme-play-icon');
        var pauseIcon = widget.find('.bme-pause-icon');
        var volumeSlider = widget.find('.bme-volume-slider');
        var isRememberPosition = widget.hasClass('remember-position');
        var storageKeyPrefix = 'bme_audio_' + index + '_';
        
        // Set default volume from settings or localStorage
        var defaultVolume = typeof bmeSettings !== 'undefined' ? bmeSettings.defaultVolume : 0.8;
        var storedVolume = localStorage.getItem(storageKeyPrefix + 'volume');
        
        if (storedVolume !== null) {
            audio.volume = parseFloat(storedVolume);
            if (volumeSlider.length) {
                volumeSlider.val(parseFloat(storedVolume) * 100);
            }
        } else {
            audio.volume = defaultVolume;
            if (volumeSlider.length) {
                volumeSlider.val(defaultVolume * 100);
            }
        }
        
        // On page load: If audio was previously started, restore position and status
        if (isRememberPosition && localStorage.getItem(storageKeyPrefix + 'started') === 'true') {
            var storedTime = localStorage.getItem(storageKeyPrefix + 'currentTime');
            if (storedTime) {
                audio.currentTime = parseFloat(storedTime);
            }
            
            if (localStorage.getItem(storageKeyPrefix + 'playing') === 'true') {
                // Try to play audio, but handle autoplay restrictions
                playAudio(audio, playIcon, pauseIcon, storageKeyPrefix);
            } else {
                playIcon.show();
                pauseIcon.hide();
            }
        } else {
            playIcon.show();
            pauseIcon.hide();
        }
        
        // Play/Pause button click event
        playPauseBtn.on('click', function() {
            if (audio.paused) {
                playAudio(audio, playIcon, pauseIcon, storageKeyPrefix);
            } else {
                pauseAudio(audio, playIcon, pauseIcon, storageKeyPrefix);
            }
        });
        
        // Volume control
        if (volumeSlider.length) {
            volumeSlider.on('input', function() {
                var volume = $(this).val() / 100;
                audio.volume = volume;
                localStorage.setItem(storageKeyPrefix + 'volume', volume);
            });
        }
        
        // Save position before unloading page
        if (isRememberPosition) {
            $(window).on('beforeunload', function() {
                localStorage.setItem(storageKeyPrefix + 'currentTime', audio.currentTime);
            });
            
            // Update time periodically while playing
            setInterval(function() {
                if (!audio.paused) {
                    localStorage.setItem(storageKeyPrefix + 'currentTime', audio.currentTime);
                }
            }, 1000);
        }
    }
    
    /**
     * Setup background audio without visible controls
     */
    function setupBackgroundAudio(audioId) {
        var audio = document.getElementById(audioId);
        var storageKeyPrefix = 'bme_audio_bg_';
        
        // Set default volume
        var defaultVolume = typeof bmeSettings !== 'undefined' ? bmeSettings.defaultVolume : 0.8;
        var storedVolume = localStorage.getItem(storageKeyPrefix + 'volume');
        
        if (storedVolume !== null) {
            audio.volume = parseFloat(storedVolume);
        } else {
            audio.volume = defaultVolume;
        }
        
        // If remember position is enabled and was previously playing
        if (typeof bmeSettings !== 'undefined' && bmeSettings.rememberPosition && 
            localStorage.getItem(storageKeyPrefix + 'started') === 'true') {
            
            var storedTime = localStorage.getItem(storageKeyPrefix + 'currentTime');
            if (storedTime) {
                audio.currentTime = parseFloat(storedTime);
            }
            
            if (localStorage.getItem(storageKeyPrefix + 'playing') === 'true') {
                // Try to play audio, but handle autoplay restrictions
                audio.play().then(function() {
                    localStorage.setItem(storageKeyPrefix + 'playing', 'true');
                }).catch(function(e) {
                    console.log("Background audio autoplay blocked:", e);
                    localStorage.setItem(storageKeyPrefix + 'playing', 'false');
                });
            }
            
            // Save position before unloading page
            $(window).on('beforeunload', function() {
                localStorage.setItem(storageKeyPrefix + 'currentTime', audio.currentTime);
            });
            
            // Update time periodically while playing
            setInterval(function() {
                if (!audio.paused) {
                    localStorage.setItem(storageKeyPrefix + 'currentTime', audio.currentTime);
                }
            }, 1000);
        }
    }
    
    /**
     * Play audio with error handling
     */
    function playAudio(audio, playIcon, pauseIcon, storageKeyPrefix) {
        audio.play().then(function() {
            playIcon.hide();
            pauseIcon.show();
            localStorage.setItem(storageKeyPrefix + 'started', 'true');
            localStorage.setItem(storageKeyPrefix + 'playing', 'true');
        }).catch(function(e) {
            console.log("Audio playback blocked:", e);
            // Keep play icon visible if autoplay is blocked
            playIcon.show();
            pauseIcon.hide();
        });
    }
    
    /**
     * Pause audio and update UI
     */
    function pauseAudio(audio, playIcon, pauseIcon, storageKeyPrefix) {
        audio.pause();
        playIcon.show();
        pauseIcon.hide();
        localStorage.setItem(storageKeyPrefix + 'playing', 'false');
    }
    
})(jQuery);
