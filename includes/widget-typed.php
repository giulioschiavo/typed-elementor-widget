<?php
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Core\Schemes\Typography;

class Typeelwi_Widget_Typed extends Widget_Base {

	public function get_name() {
		return 'typeelwi_typed';
	}

	public function get_title() {
		return esc_html__( 'Typed.js Animator', 'typed-elementor-widget' );
	}

	public function get_icon() {
		return 'eicon-animation-text';
	}

	public function get_categories() {
		return [ 'general' ];
	}

	public function get_keywords() {
		return [ 'typed', 'typing', 'animation', 'text', 'typewriter' ];
	}

	public function get_script_depends() {
		return [ 'typed-js', 'typeelwi-init' ];
	}

	public function get_style_depends() {
		return [ 'typeelwi-style' ];
	}

	/* ---------------------------------------------------------------
	 * CONTROLS
	 * ------------------------------------------------------------- */
	protected function register_controls() {

		/* === SECTION: TEXTS === */
		$this->start_controls_section(
			'section_content',
			[
				'label' => esc_html__( 'Texts', 'typed-elementor-widget' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$repeater = new Repeater();
		$repeater->add_control(
			'text',
			[
				'label'       => esc_html__( 'Text', 'typed-elementor-widget' ),
				'type'        => Controls_Manager::TEXT,
				'default'     => esc_html__( 'Type your text here...', 'typed-elementor-widget' ),
				'label_block' => true,
			]
		);

		$this->add_control(
			'strings',
			[
				'label'       => esc_html__( 'Text Lines', 'typed-elementor-widget' ),
				'type'        => Controls_Manager::REPEATER,
				'fields'      => $repeater->get_controls(),
				'default'     => [
                	[ 'text' => esc_html__( 'Hello, I am an animated heading!', 'typed-elementor-widget' ) ],
                	[ 'text' => esc_html__( 'This is Typed.js for Elementor.', 'typed-elementor-widget' ) ],
                	[ 'text' => esc_html__( 'Customize it however you want.', 'typed-elementor-widget' ) ],
                ],
				'title_field' => '{{ text }}',
			]
		);

		$this->end_controls_section();

		/* === SECTION: ANIMATION === */
		$this->start_controls_section(
			'section_animation',
			[
				'label' => esc_html__( 'Animation', 'typed-elementor-widget' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'type_speed',
			[
				'label'   => esc_html__( 'Typing Speed (ms)', 'typed-elementor-widget' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [ 'px' => [ 'min' => 10, 'max' => 500, 'step' => 5 ] ],
				'default' => [ 'size' => 50 ],
			]
		);

		$this->add_control(
			'back_speed',
			[
				'label' => esc_html__( 'Backspace Speed (ms)', 'typed-elementor-widget' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [ 'px' => [ 'min' => 10, 'max' => 500, 'step' => 5 ] ],
				'default' => [ 'size' => 30 ],
			]
		);

		$this->add_control(
			'start_delay',
			[
				'label' => esc_html__( 'Start Delay (ms)', 'typed-elementor-widget' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [ 'px' => [ 'min' => 0, 'max' => 5000, 'step' => 100 ] ],
				'default' => [ 'size' => 0 ],
			]
		);

		$this->add_control(
			'back_delay',
			[
				'label' => esc_html__( 'Back Delay (ms)', 'typed-elementor-widget' ),
				'type'    => Controls_Manager::SLIDER,
				'range'   => [ 'px' => [ 'min' => 100, 'max' => 5000, 'step' => 100 ] ],
				'default' => [ 'size' => 700 ],
			]
		);

		$this->add_control(
			'loop',
			[
				'label'        => esc_html__( 'Loop', 'typed-elementor-widget' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'typed-elementor-widget' ),
				'label_off'    => esc_html__( 'No', 'typed-elementor-widget' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'fade_out',
			[
				'label' => esc_html__( 'Fade Out (instead of deleting)', 'typed-elementor-widget' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'typed-elementor-widget' ),
				'label_off'    => esc_html__( 'No', 'typed-elementor-widget' ),
				'return_value' => 'yes',
				'default'      => '',
			]
		);

		$this->end_controls_section();

		/* === SECTION: CURSOR === */
		$this->start_controls_section(
			'section_cursor',
			[
				'label' => esc_html__( 'Cursor', 'typed-elementor-widget' ),
				'tab'   => Controls_Manager::TAB_CONTENT,
			]
		);

		$this->add_control(
			'show_cursor',
			[
				'label' => esc_html__( 'Show Cursor', 'typed-elementor-widget' ),
				'type'         => Controls_Manager::SWITCHER,
				'label_on'     => esc_html__( 'Yes', 'typed-elementor-widget' ),
				'label_off'    => esc_html__( 'No', 'typed-elementor-widget' ),
				'return_value' => 'yes',
				'default'      => 'yes',
			]
		);

		$this->add_control(
			'cursor_char',
			[
				'label' => esc_html__( 'Cursor Character', 'typed-elementor-widget' ),
				'type'      => Controls_Manager::TEXT,
				'default'   => '|',
				'condition' => [ 'show_cursor' => 'yes' ],
			]
		);

		$this->add_control(

        	'cursor_color',
        	[
        		'label'     => esc_html__( 'Cursor Color', 'typed-elementor-widget' ),
        		'type'      => Controls_Manager::COLOR,
        		'default'   => '#000000',
        		'condition' => [ 'show_cursor' => 'yes' ],
        		'selectors' => [
        			'{{WRAPPER}} .typed-cursor' => 'color: {{VALUE}};',
        		],
        	]
        
        );

		$this->end_controls_section();

		/* === STYLE SECTION: TEXT === */
		$this->start_controls_section(
			'section_style_text',
			[
				'label' => esc_html__( 'Text Style', 'typed-elementor-widget' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_control(
			'text_color',
			[
				'label' => esc_html__( 'Text Color', 'typed-elementor-widget' ),
				'type'      => Controls_Manager::COLOR,
				'default'   => '#000000',
				'selectors' => [
					'{{WRAPPER}} .typeelwi-typed-output' => 'color: {{VALUE}};',
				],
			]
		);

		$this->add_control(
			'text_align',
			[
				'label'     => esc_html__( 'Alignment', 'typed-elementor-widget' ),
				'type'      => Controls_Manager::CHOOSE,
				'options'   => [
                	'left'   => [ 'title' => esc_html__( 'Left', 'typed-elementor-widget' ), 'icon' => 'eicon-text-align-left' ],
                	'center' => [ 'title' => esc_html__( 'Center', 'typed-elementor-widget' ), 'icon' => 'eicon-text-align-center' ],
                	'right'  => [ 'title' => esc_html__( 'Right', 'typed-elementor-widget' ), 'icon' => 'eicon-text-align-right' ],
                ],
				'default'   => 'left',
				'selectors' => [
					'{{WRAPPER}} .typeelwi-typed-wrapper' => 'text-align: {{VALUE}};',
				],
			]
		);
		
		$this->add_control(

	'font_family',
	[
		'label'     => esc_html__( 'Font', 'typed-elementor-widget' ),
		'type'      => Controls_Manager::FONT,
		'default'   => '',
		'selectors' => [
			'{{WRAPPER}} .typeelwi-typed-output' => 'font-family: {{VALUE}};',
			'{{WRAPPER}} .typed-cursor'     => 'font-family: {{VALUE}};',
		],
	]

);
        
		$this->add_control(
			'font_weight',
			[
				'label'     => esc_html__( 'Font Weight', 'typed-elementor-widget' ),
				'type'      => Controls_Manager::SELECT,
				'default'   => '400',
				'options'   => [
					'100' => '100 – Thin',
					'200' => '200 – Extra Light',
					'300' => '300 – Light',
					'400' => '400 – Normal',
					'500' => '500 – Medium',
					'600' => '600 – Semi Bold',
					'700' => '700 – Bold',
					'800' => '800 – Extra Bold',
					'900' => '900 – Black',
				],
				'selectors' => [
					'{{WRAPPER}} .typeelwi-typed-output' => 'font-weight: {{VALUE}};',
				],
			]
		);

		

		$this->end_controls_section();

		/* === STYLE SECTION: RESPONSIVE SIZE === */
		$this->start_controls_section(
			'section_style_size',
			[
				'label' => esc_html__( 'Font Size', 'typed-elementor-widget' ),
				'tab'   => Controls_Manager::TAB_STYLE,
			]
		);

		$this->add_responsive_control(
			'font_size',
			[
				'label'      => esc_html__( 'Font Size', 'typed-elementor-widget' ),
				'type'       => Controls_Manager::SLIDER,
				'size_units' => [ 'px', 'em', 'rem', 'vw' ],
				'range'      => [
					'px'  => [ 'min' => 8,   'max' => 200, 'step' => 1 ],
					'em'  => [ 'min' => 0.5, 'max' => 10,  'step' => 0.1 ],
					'rem' => [ 'min' => 0.5, 'max' => 10,  'step' => 0.1 ],
					'vw'  => [ 'min' => 1,   'max' => 20,  'step' => 0.1 ],
				],
				'default'        => [ 'unit' => 'px', 'size' => 32 ],
				'tablet_default' => [ 'unit' => 'px', 'size' => 24 ],
				'mobile_default' => [ 'unit' => 'px', 'size' => 20 ],
				'selectors'      => [
					'{{WRAPPER}} .typeelwi-typed-output' => 'font-size: {{SIZE}}{{UNIT}};',
				],
			]
		);
		
		$this->add_responsive_control(

        	'line_height',
        	[
        		'label'      => esc_html__( 'Line Height', 'typed-elementor-widget' ),
        		'type'       => Controls_Manager::SLIDER,
        		'size_units' => [ 'em', 'px' ],
        		'range'      => [
        			'em' => [
        				'min'  => 0.5,
        				'max'  => 4,
        				'step' => 0.1,
        			],
        			'px' => [
        				'min'  => 10,
        				'max'  => 200,
        				'step' => 1,
        			],
        		],
        		'default'        => [
        			'unit' => 'em',
        			'size' => 1.2,
        		],
        		'tablet_default' => [
        			'unit' => 'em',
        			'size' => 1.15,
        		],
        		'mobile_default' => [
        			'unit' => 'em',
        			'size' => 1.1,
        		],
        		'selectors' => [
        			'{{WRAPPER}} .typeelwi-typed-output' => 'line-height: {{SIZE}}{{UNIT}};',
        			'{{WRAPPER}} .typed-cursor'     => 'line-height: {{SIZE}}{{UNIT}};',
        		],
        	]
        
        );

		$this->end_controls_section();
	}

	/* ---------------------------------------------------------------
     * HTML RENDERING (frontend + editor preview)
     * ------------------------------------------------------------- */
	protected function render() {
		$settings = $this->get_settings_for_display();

		$strings = [];
		if ( ! empty( $settings['strings'] ) ) {
			foreach ( $settings['strings'] as $item ) {
				if ( isset( $item['text'] ) ) {
					$strings[] = sanitize_text_field( $item['text'] );
				}
			}
		}

		$config = [
			'strings'    => $strings,
			'typeSpeed'  => isset( $settings['type_speed']['size'] )  ? (int) $settings['type_speed']['size']  : 50,
			'backSpeed'  => isset( $settings['back_speed']['size'] )   ? (int) $settings['back_speed']['size']  : 30,
			'startDelay' => isset( $settings['start_delay']['size'] )  ? (int) $settings['start_delay']['size'] : 0,
			'backDelay'  => isset( $settings['back_delay']['size'] )   ? (int) $settings['back_delay']['size']  : 700,
			'loop'       => ( 'yes' === $settings['loop'] ),
			'showCursor' => ( 'yes' === $settings['show_cursor'] ),
			'cursorChar' => ! empty( $settings['cursor_char'] ) ? sanitize_text_field( $settings['cursor_char'] ) : '|',
			'fadeOut'    => ( 'yes' === $settings['fade_out'] ),
		];

		$widget_id   = $this->get_id();
		$config_json = wp_json_encode( $config );
		if ( false === $config_json ) {
			$config_json = '{}';
		}
		?>
		<div
			class="typeelwi-typed-wrapper"
			data-typeelwi-widget-id="<?php echo esc_attr( $widget_id ); ?>"
			data-typeelwi-config="<?php echo esc_attr( $config_json ); ?>"
		>
			<span class="typeelwi-typed-output" id="typeelwi-typed-<?php echo esc_attr( $widget_id ); ?>"></span>
		</div>
		<?php
	}

	/* ---------------------------------------------------------------
     * Editor rendering (static block to avoid double initialization)
     * ------------------------------------------------------------- */
	protected function content_template() {
		?>
		<#
		var strings = [];
		if ( settings.strings && settings.strings.length ) {
			_.each( settings.strings, function( item ) {
				if ( item.text ) {
					strings.push( item.text );
				}
			});
		}

		var firstString = strings.length ? strings[0] : 'Typed.js Preview';
		var textAlign = settings.text_align || 'left';
		var textColor = settings.text_color || '#000000';
		var fontWeight = settings.font_weight || '400';
		var fontFamily = settings.font_family || 'inherit';
		var fontSize = settings.font_size && settings.font_size.size ? settings.font_size.size + ( settings.font_size.unit || 'px' ) : '32px';
		var lineHeight = settings.line_height && settings.line_height.size ? settings.line_height.size + ( settings.line_height.unit || 'em' ) : '1.2em';
		var showCursor = 'yes' === settings.show_cursor;
		var cursorChar = settings.cursor_char || '|';
		var cursorColor = settings.cursor_color || textColor;
		#>
		<div class="typeelwi-typed-wrapper" style="text-align: {{ textAlign }};">
			<span class="typeelwi-typed-output" style="
				color: {{ textColor }};
				font-family: {{ fontFamily }};
				font-size: {{ fontSize }};
				font-weight: {{ fontWeight }};
				line-height: {{ lineHeight }};
			">{{ firstString }}</span><# if ( showCursor ) { #><span class="typed-cursor" style="
				color: {{ cursorColor }};
				font-family: {{ fontFamily }};
				font-size: {{ fontSize }};
				font-weight: {{ fontWeight }};
				line-height: {{ lineHeight }};
			">{{ cursorChar }}</span><# } #>
		</div>
		<?php
	}
}
