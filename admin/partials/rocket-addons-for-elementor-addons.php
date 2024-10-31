<?php

/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://rocket-addons.com/
 * @since      1.0.0
 *
 * @package    Rocket_Addon
 * @subpackage Rocket_Addon/admin/partials
 */
?>

<!-- This file should primarily consist of HTML with a little bit of PHP. -->

<div class="rocket-admin-dashboard">
	<form method="POST" action="<?php echo esc_url( admin_url( 'admin-post.php' ) ); ?>">
		<input type="hidden" name="action" value="rocket_control_switch" />
		<div class="rocket-head-banner">
			<div class="head-banner-inner">
				<div class="head-banner-img">
					<img src="<?php echo esc_url( ROCKET_ADDON_URL . 'assets/rocket-head-banner.svg' ); ?>" alt="rocket-banner">
				</div>
				<div class="head-banner-btn">
					<button type="submit" class="rocket-btn"><?php esc_html_e( 'Save Settings', 'rocket-addons' ); ?></button>
				</div>
			</div>
		</div>
		<div class="rocket-dashboard-contents">
			<nav class="rocket-tab">
				<div class="nav nav-tabs" id="nav-tab" role="tablist">
					<a class="nav-item nav-link" href="admin.php?page=rocket-addons-for-elementor">
						<i class="batavia icon-gears-setting"></i>
						<?php esc_html_e( 'General', 'rocket-addons' ); ?>
					</a>
					<a class="nav-item nav-link active" href="admin.php?page=rocket-addons-for-elementor-addons">
						<i class="batavia icon-box"></i>
						<?php esc_html_e( 'Add-Ons', 'rocket-addons' ); ?>
					</a>
					<?php if ( rocket_addons_fs()->is__premium_only() ) { ?>
					<a class="nav-item nav-link" href="admin.php?page=rocket-addons-for-elementor-account">
						<i class="batavia icon-wrench1"></i>
						<?php esc_html_e( 'Account', 'rocket-addons' ); ?>
					</a>
					<?php } ?>
					<a class="nav-item nav-link" href="admin.php?page=rocket-addons-for-elementor-contact">
						<i class="batavia icon-plug"></i>
						<?php esc_html_e( 'Contact Us', 'rocket-addons' ); ?>
					</a>
					<?php if ( rocket_addons_fs()->is_not_paying() ) { ?>
					<a class="nav-item nav-link" href="<?php echo esc_url( rocket_addons_fs()->get_upgrade_url() ); ?>">
						<i class="batavia icon-unlock"></i>
						<?php esc_html_e( 'Go Premium', 'rocket-addons' ); ?>
					</a>
					<?php } ?>
				</div>
			</nav>
			<div class="rocket-tab-content tab-content" id="nav-tabContent">
				<div class="addons-content-head">
					<h3 class="rsection-title">
						<?php esc_html_e( 'GLOBAL CONTROL', 'rocket-addons' ); ?>
					</h3>
					<p class="rsection-desc"><?php esc_html_e( 'Use the Buttons to Activate or Deactivate all the Elements of Essential Addons at once.', 'rocket-addons' ); ?></p>
					<div class="rsection-main-control">
						<div class="rm-control rcontrol-enable">
							<?php esc_html_e( 'Enable All', 'rocket-addons' ); ?>
						</div>
						<div class="rm-control rcontrol-disable">
							<?php esc_html_e( 'Disable All', 'rocket-addons' ); ?>
						</div>
					</div>
				</div>
				<div class="rocket-home-content rhome-addons">
					<div class="left-section rhome-section">

						<?php
							$single_condition = get_option( 'rocket_addons_single_condition' );
							$multi_condition  = get_option( 'rocket_addons_multi_condition' );
							$rocket_ifthen    = get_option( 'rocket_addons_ifthen' );
							$rocket_total     = get_option( 'rocket_addons_total' );
						?>

						<div class="rocket-feature-control">
							<div class="rcontrol">
								<div class="rspacer"></div>
								<div class="rcontrol-title">
									<?php esc_html_e( 'Conditional Visibility - ', 'rocket-addons' ); ?><br>
									<?php esc_html_e( 'Single Condition', 'rocket-addons' ); ?>
								</div>
								<div class="rcontrol-switch switch">
									<input id="rcontrol-vis-singlecon" type="checkbox" name="rcontrol-vis-singlecon" class="rswitch"<?php if ( 'on' === $single_condition ) { echo esc_attr( 'checked' ); } ?>>
									<span class="slider round"></span>
								</div>
								<label for="rcontrol-vis-singlecon" class="floating-label"></label>
							</div>
						</div>

						<div class="rocket-feature-control<?php if ( rocket_addons_fs()->is_not_paying() ) { ?> disabled<?php } ?>">
							<div class="rcontrol">
								<div class="rlabel pro-label"><?php esc_html_e( 'PRO', 'rocket-addons' ); ?></div>
								<div class="rspacer"></div>
								<div class="rcontrol-title">
									<?php esc_html_e( 'Conditional Visibility - ', 'rocket-addons' ); ?><br>
									<?php esc_html_e( 'Multiple Condition', 'rocket-addons' ); ?>
								</div>
								<div class="rcontrol-switch switch">
									<input id="rcontrol-vis-multicon" type="checkbox" name="rcontrol-vis-multicon" class="rswitch"<?php if ( 'on' === $multi_condition ) { echo esc_attr( 'checked' ); } if ( rocket_addons_fs()->is_not_paying() ) { ?> disabled<?php } ?> />
									<span class="slider round"></span>
								</div>
								<label for="rcontrol-vis-multicon" class="floating-label"></label>
							</div>
						</div>

						<div class="rocket-feature-control<?php if ( rocket_addons_fs()->is_not_paying() ) { ?> disabled<?php } ?>">
							<div class="rcontrol">
								<div class="rlabel pro-label"><?php esc_html_e( 'PRO', 'rocket-addons' ); ?></div>
								<div class="rspacer"></div>
								<div class="rcontrol-title">
									<?php esc_html_e( 'IF THEN - ', 'rocket-addons' ); ?><br>
									<?php esc_html_e( 'Conditional Values', 'rocket-addons' ); ?>
								</div>
								<div class="rcontrol-switch switch">
									<input id="rcontrol-ifthen" type="checkbox" name="rcontrol-ifthen" class="rswitch"<?php if ( 'on' === $rocket_ifthen ) { echo esc_attr( 'checked' ); } if ( rocket_addons_fs()->is_not_paying() ) { ?> disabled<?php } ?> />
									<span class="slider round"></span>
								</div>
								<label for="rcontrol-ifthen" class="floating-label"></label>
							</div>
						</div>

						<div class="rocket-feature-control<?php if ( rocket_addons_fs()->is_not_paying() ) { ?> disabled<?php } ?>">
							<div class="rcontrol">
								<div class="rlabel pro-label"><?php esc_html_e( 'PRO', 'rocket-addons' ); ?></div>
								<div class="rspacer"></div>
								<div class="rcontrol-title">
									<?php esc_html_e( 'Total Cost - ', 'rocket-addons' ); ?><br>
									<?php esc_html_e( 'Calculator', 'rocket-addons' ); ?>
								</div>
								<div class="rcontrol-switch switch">
									<input id="rcontrol-total" type="checkbox" name="rcontrol-total" class="rswitch"<?php if ( 'on' === $rocket_total ) { echo esc_attr( 'checked' ); } if ( rocket_addons_fs()->is_not_paying() ) { ?> disabled<?php } ?> />
									<span class="slider round"></span>
								</div>
								<label for="rcontrol-total" class="floating-label"></label>
							</div>
						</div>

					</div>
					<div class="right-section rhome-section">
						<div class="rocket-upgrade-area">
							<img src="<?php echo esc_url( ROCKET_ADDON_URL . 'assets/rocket-upgrade.svg' ); ?>" alt="rocket-banner">
							<?php if ( rocket_addons_fs()->is_not_paying() ) { ?>
							<div class="rbutton-upgrade">
								<a href="<?php echo esc_url( rocket_addons_fs()->get_upgrade_url() ); ?>" class="rbutton"><?php esc_html_e( 'Upgrade to Pro', 'rocket-addons' ); ?></a>
							</div>
							<?php } else { ?>
								<div class="rbutton-upgrade">
									<a href="<?php echo esc_url( rocket_addons_fs()->get_account_url() ); ?>" class="rbutton"><?php esc_html_e( 'See Your Plan', 'rocket-addons' ); ?></a>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</form>
</div>
