<div class="ai1ec-panel-heading">
	<a data-toggle="ai1ec-collapse"
		data-parent="#osec-add-new-event-accordion"
		href="#osec-event-cost-box">
		<i class="ai1ec-fa ai1ec-fa-shopping-cart ai1ec-fa-fw"></i>
		<?php _e( 'Event cost and Tickets', OSEC_TXT_DOM ); ?>
		<i class="ai1ec-fa ai1ec-fa-warning ai1ec-fa-fw ai1ec-hidden"></i>
	</a>
</div>
<div id="osec-event-cost-box" class="ai1ec-panel-collapse ai1ec-collapse">
	<div class="ai1ec-panel-body">
		<table class="ai1ec-form">
			<tbody>
				<tr>
					<td class="ai1ec-first ai1ec-cost-label">
						<label for="osec_cost">
							<?php _e( 'Cost', OSEC_TXT_DOM ); ?>:
						</label>
					</td>
					<td>
						<input type="text"
							name="osec_cost"
							class="ai1ec-form-control"
							id="osec_cost" <?php
							if ( ! empty( $is_free ) ) {
								echo 'class="ai1ec-hidden" ';
							}
						 ?>value="<?php echo esc_attr( $cost ); ?>">
						<label for="osec_is_free_event">
							<input class="checkbox"
								type="checkbox"
								name="osec_is_free_event"
								id="osec_is_free_event"
								value="1" <?php echo $is_free; ?>>
							<?php _e( 'Free event', OSEC_TXT_DOM ); ?>
						</label>
					</td>
				</tr>
				<tr>
					<td>
						<label for="osec_ticket_url"><?php
							echo ( ! empty( $is_free ) )
									 ? __( 'Registration URL:', OSEC_TXT_DOM )
									 : __( 'Buy Tickets URL:', OSEC_TXT_DOM );
						?></label>
					</td>
					<td>
						<input type="text" name="osec_ticket_url" id="osec_ticket_url"
							class="ai1ec-form-control"
							value="<?php echo esc_attr( $ticket_url ); ?>">
					</td>
				</tr>
			</tbody>
		</table>
	</div>
</div>
