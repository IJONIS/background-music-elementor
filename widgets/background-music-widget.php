<?php

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly.
}

/**
 * Background Music Widget for Elementor
 *
 * @since 1.0.0
 */
class Background_Music_Widget extends \Elementor\Widget_Base {

    /**
     * Get widget name.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget name.
     */
    public function get_name() {
        return 'background_music';
    }

    /**
     * Get widget title.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget title.
     */
    public function get_title() {
        return esc_html__('Background Music', 'background-music-elementor-1');
    }

    /**
     * Get widget icon.
     *
     * @since 1.0.0
     * @access public
     * @return string Widget icon.
     */
    public function get_icon() {
        return 'eicon-play';
    }

    /**
     * Get widget categories.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget categories.
     */
    public function get_categories() {
        return ['general'];
    }

    /**
     * Get widget keywords.
     *
     * @since 1.0.0
     * @access public
     * @return array Widget keywords.
     */
    public function get_keywords() {
        return ['music', 'audio', 'sound', 'player', 'background'];
    }

    /**
     * Register widget controls.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _register_controls() {
        // Content Section
        $this->start_controls_section(
            'content_section',
            [
                'label' => esc_html__('Audio Settings', 'background-music-elementor-1'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'audio_file',
            [
                'label' => esc_html__('Audio File', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::MEDIA,
                'media_type' => 'audio',
                'default' => [
                    'url' => '',
                ],
            ]
        );

        $this->add_control(
            'loop',
            [
                'label' => esc_html__('Loop Audio', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'background-music-elementor-1'),
                'label_off' => esc_html__('No', 'background-music-elementor-1'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->add_control(
            'remember_position',
            [
                'label' => esc_html__('Remember Position', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Yes', 'background-music-elementor-1'),
                'label_off' => esc_html__('No', 'background-music-elementor-1'),
                'return_value' => 'yes',
                'default' => 'yes',
                'description' => esc_html__('Remember audio position when navigating between pages', 'background-music-elementor-1'),
            ]
        );

        $this->add_control(
            'show_player',
            [
                'label' => esc_html__('Show Player Button', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'background-music-elementor-1'),
                'label_off' => esc_html__('Hide', 'background-music-elementor-1'),
                'return_value' => 'yes',
                'default' => 'yes',
            ]
        );

        $this->end_controls_section();

        // Button Style Section
        $this->start_controls_section(
            'button_style_section',
            [
                'label' => esc_html__('Button Style', 'background-music-elementor-1'),
                'tab' => \Elementor\Controls_Manager::TAB_STYLE,
                'condition' => [
                    'show_player' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'button_background_color',
            [
                'label' => esc_html__('Background Color', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#A64446',
                'selectors' => [
                    '{{WRAPPER}} .bme-audio-widget' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'button_hover_background_color',
            [
                'label' => esc_html__('Hover Background Color', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#B85557',
                'selectors' => [
                    '{{WRAPPER}} .bme-audio-widget:hover' => 'background-color: {{VALUE}}',
                ],
            ]
        );

        $this->add_control(
            'icon_color',
            [
                'label' => esc_html__('Icon Color', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .bme-play-pause-btn' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .bme-play-pause-btn svg' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_control(
            'icon_hover_color',
            [
                'label' => esc_html__('Icon Hover Color', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#FFFFFF',
                'selectors' => [
                    '{{WRAPPER}} .bme-play-pause-btn:hover' => 'color: {{VALUE}} !important;',
                    '{{WRAPPER}} .bme-play-pause-btn:hover svg' => 'color: {{VALUE}} !important; fill: {{VALUE}} !important;',
                ],
            ]
        );

        $this->add_responsive_control(
            'button_size',
            [
                'label' => esc_html__('Button Size', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 20,
                        'max' => 200,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 75,
                ],
                'selectors' => [
                    '{{WRAPPER}} .bme-audio-widget' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'icon_size',
            [
                'label' => esc_html__('Icon Size', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 10,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 50,
                ],
                'selectors' => [
                    '{{WRAPPER}} .bme-play-pause-btn svg' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Border::get_type(),
            [
                'name' => 'button_border',
                'selector' => '{{WRAPPER}} .bme-audio-widget',
                'separator' => 'before',
            ]
        );

        $this->add_responsive_control(
            'button_border_radius',
            [
                'label' => esc_html__('Border Radius', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '8',
                    'right' => '8',
                    'bottom' => '8',
                    'left' => '8',
                    'unit' => 'px',
                    'isLinked' => true,
                ],
                'selectors' => [
                    '{{WRAPPER}} .bme-audio-widget' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            \Elementor\Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'button_box_shadow',
                'selector' => '{{WRAPPER}} .bme-audio-widget',
            ]
        );

        $this->end_controls_section();

        // Additional Controls Section
        $this->start_controls_section(
            'additional_controls_section',
            [
                'label' => esc_html__('Additional Controls', 'background-music-elementor-1'),
                'tab' => \Elementor\Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'show_volume',
            [
                'label' => esc_html__('Show Volume Control', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SWITCHER,
                'label_on' => esc_html__('Show', 'background-music-elementor-1'),
                'label_off' => esc_html__('Hide', 'background-music-elementor-1'),
                'return_value' => 'yes',
                'default' => 'no',
                'condition' => [
                    'show_player' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'default_volume',
            [
                'label' => esc_html__('Default Volume', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['%'],
                'range' => [
                    '%' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => '%',
                    'size' => 80,
                ],
                'condition' => [
                    'show_player' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'volume_control_background_color',
            [
                'label' => esc_html__('Volume Control Background', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::COLOR,
                'default' => '#A64446',
                'selectors' => [
                    '{{WRAPPER}} .bme-volume-control' => 'background-color: {{VALUE}}',
                ],
                'condition' => [
                    'show_volume' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'volume_control_distance',
            [
                'label' => esc_html__('Volume Control Distance', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['px'],
                'range' => [
                    'px' => [
                        'min' => 0,
                        'max' => 100,
                        'step' => 1,
                    ],
                ],
                'default' => [
                    'unit' => 'px',
                    'size' => 0,
                ],
                'selectors' => [
                    '{{WRAPPER}} .bme-volume-control' => 'bottom: calc(-36px - {{SIZE}}{{UNIT}});',
                    '{{WRAPPER}} .bme-audio-widget::after' => 'bottom: -15px; height: calc(15px + {{SIZE}}{{UNIT}});',
                ],
                'condition' => [
                    'show_volume' => 'yes',
                ],
            ]
        );

        $this->add_responsive_control(
            'volume_control_border_radius',
            [
                'label' => esc_html__('Volume Control Border Radius', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::DIMENSIONS,
                'size_units' => ['px', '%'],
                'default' => [
                    'top' => '0',
                    'right' => '0',
                    'bottom' => '8',
                    'left' => '8',
                    'unit' => 'px',
                    'isLinked' => false,
                ],
                'selectors' => [
                    '{{WRAPPER}} .bme-volume-control' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
                'condition' => [
                    'show_volume' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'volume_control_transition',
            [
                'label' => esc_html__('Volume Control Transition', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SELECT,
                'default' => 'fade',
                'options' => [
                    'fade' => esc_html__('Fade', 'background-music-elementor-1'),
                    'slide' => esc_html__('Slide', 'background-music-elementor-1'),
                    'none' => esc_html__('None', 'background-music-elementor-1'),
                ],
                'condition' => [
                    'show_volume' => 'yes',
                ],
            ]
        );

        $this->add_control(
            'volume_control_transition_speed',
            [
                'label' => esc_html__('Transition Speed (s)', 'background-music-elementor-1'),
                'type' => \Elementor\Controls_Manager::SLIDER,
                'size_units' => ['s'],
                'range' => [
                    's' => [
                        'min' => 0.1,
                        'max' => 2,
                        'step' => 0.1,
                    ],
                ],
                'default' => [
                    'unit' => 's',
                    'size' => 0.3,
                ],
                'condition' => [
                    'show_volume' => 'yes',
                    'volume_control_transition!' => 'none',
                ],
            ]
        );

        $this->end_controls_section();
    }

    /**
     * Render widget output on the frontend.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function render() {
        $settings = $this->get_settings_for_display();

        // Audio file URL
        $audio_url = $settings['audio_file']['url'];

        // Loop attribute
        $loop_attr = $settings['loop'] == 'yes' ? 'loop' : '';

        // Remember position class
        $remember_position_class = $settings['remember_position'] == 'yes' ? 'remember-position' : '';

        // Volume settings
        $default_volume = intval($settings['default_volume']['size']);
        $volume_control = $settings['show_volume'] == 'yes' ? true : false;
        
        // Volume transition effect
        $transition_effect = isset($settings['volume_control_transition']) ? $settings['volume_control_transition'] : 'fade';
        $transition_speed = isset($settings['volume_control_transition_speed']['size']) ? $settings['volume_control_transition_speed']['size'] : 0.3;
        $transition_class = 'bme-transition-' . $transition_effect;

        // Render the widget
        if ($settings['show_player'] == 'yes') {
            echo '<div class="bme-audio-widget ' . esc_attr($remember_position_class) . '">';
            echo '  <button class="bme-play-pause-btn">';
            echo '    <svg class="bme-play-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">';
            echo '      <path d="M8 5v14l11-7L8 5z" fill="currentColor"/>';
            echo '    </svg>';
            echo '    <svg class="bme-pause-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none;">';
            echo '      <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" fill="currentColor"/>';
            echo '    </svg>';
            echo '  </button>';
            
            // Volume control
            if ($volume_control) {
                echo '  <div class="bme-volume-control ' . esc_attr($transition_class) . '" style="transition-duration: ' . esc_attr($transition_speed) . 's;">';
                echo '    <input type="range" class="bme-volume-slider" min="0" max="100" value="' . esc_attr($default_volume) . '">';
                echo '  </div>';
            }
            
            echo '</div>';
        }

        // Audio element
        echo '<audio id="bme-bg-music" ' . esc_attr($loop_attr) . ' class="bme-audio-element">';
        echo '  <source src="' . esc_url($audio_url) . '" type="audio/mp3">';
        echo '  ' . esc_html__('Your browser does not support HTML5 audio.', 'background-music-elementor-1');
        echo '</audio>';

        // Include frontend script
        wp_enqueue_script('background-music-elementor-1');
        
        // Pass data to the script
        wp_localize_script('background-music-elementor-1', 'bmeSettings', [
            'rememberPosition' => $settings['remember_position'] == 'yes',
            'defaultVolume' => $default_volume / 100,
        ]);
    }

    /**
     * Render widget output in the editor.
     *
     * @since 1.0.0
     * @access protected
     */
    protected function _content_template() {
        ?>
        <# 
        var loopAttr = settings.loop == 'yes' ? 'loop' : '';
        var rememberPositionClass = settings.remember_position == 'yes' ? 'remember-position' : '';
        
        var defaultVolume = parseInt(settings.default_volume.size);
        var volumeControl = settings.show_volume == 'yes' ? true : false;
        #>
        
        <# if (settings.show_player == 'yes') { #>
        <div class="bme-audio-widget {{ rememberPositionClass }}">
            <button class="bme-play-pause-btn">
                <svg class="bme-play-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M8 5v14l11-7L8 5z" fill="currentColor"/>
                </svg>
                <svg class="bme-pause-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" style="display:none;">
                    <path d="M6 19h4V5H6v14zm8-14v14h4V5h-4z" fill="currentColor"/>
                </svg>
            </button>
            
            <# if (volumeControl) { #>
            <div class="bme-volume-control">
                <input type="range" class="bme-volume-slider" min="0" max="100" value="{{ defaultVolume }}">
            </div>
            <# } #>
        </div>
        <# } #>
        
        <audio id="bme-bg-music" {{{ loopAttr }}} class="bme-audio-element">
            <source src="{{ settings.audio_file.url }}" type="audio/mp3">
            <?php echo esc_html__('Your browser does not support HTML5 audio.', 'background-music-elementor-1'); ?>
        </audio>
        <?php
    }
}
