<!-- END MODULE: Menu 9 -->

<table border='0' cellspacing='0' cellpadding='0' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
	<tbody>
		<tr>
			<td style='vertical-align: top; padding: 0; height: 8px; -webkit-text-size-adjust: 100%; font-size: 8px; line-height: 8px;' valign='top'>&nbsp;</td>
        </tr>
	</tbody>
</table>
<table border='0' cellpadding='0' cellspacing='0' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
	<tbody>
		<tr>
			<td class='pc-cta-box-s4' style='vertical-align: top; background-color: #ffffff; border-radius: 8px; box-shadow: 0 2px 4px 0 rgba(0, 0, 0, 0.1)' valign='top' bgcolor='#ffffff'>
				<table border='0' cellpadding='0' cellspacing='0' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
					<tbody>
						<tr>
							<td class='pc-cta-box-in' style='vertical-align: top; padding: 40px 40px 35px;' valign='top'>
								<table class='pc-cta-s1' border='0' cellpadding='0' cellspacing='0' style='mso-table-lspace: 0pt; mso-table-rspace: 0pt; width: 100%;' width='100%'>
                                    <tbody>

										<tr>
											<td class='pc-cta-title pc-fb-font' style='vertical-align: top; font-family: Fira San, Helvetica, Arial, sans-serif; font-size: 36px; font-weight: 900; line-height: 1.28;  color: #151515; text-align: left;' valign='top' align='left'> Potvrda narudžbe</td>
										</tr>

										<tr>
											<td style='vertical-align: top; height: 20px; line-height: 20px; font-size: 20px;' valign='top'>&nbsp;</td>
										</tr>
										<tr>
											<td class='pc-cta-text pc-fb-font' style='vertical-align: top; padding: 10px 0 10px 0; font-family: Fira San, Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; color: #9B9B9B; text-align: left;' valign='top' align='left'> Zahvaljujemo se na kupovini na poslovnibiro.rs</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400;  color: #151515;' valign='top'>Broj narudžbe: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; color: #151515;'>{$orderid}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400;  color: #151515;' valign='top'>Datum narudžbe: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700;  color: #151515;'>{$date}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; color: #151515;' valign='top'>Način plaćanja: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; color: #151515;'>{$ordertype}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 10px 0px 10px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 20px; font-weight: 700; color: #151515;' valign='top'>Podaci o naručiocu
											</td>
										</tr>
										{if $user.firm neq ""}
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; color: #151515;' valign='top'>Naziv preduzeća: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700;  color: #151515;'>{$user.firm}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; color: #151515;' valign='top'>Služba: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700;  color: #151515;'>{$user.matbr}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; color: #151515;' valign='top'>PIB: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700;  color: #151515;'>{$user.pib}</span>
											</td>
										</tr>
										{/if}
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; color: #151515;' valign='top'>Ime i prezime naručioca: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700;  color: #151515;'>{$user.name} {$user.surname}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; color: #151515;' valign='top'>Adresa naručioca: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700;  color: #151515;'>{$user.address}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; color: #151515;' valign='top'>Mesto: <span style='vertical-align: top; padding: 0px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; color: #151515;'>{$user.place}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; color: #151515;' valign='top'>E-mail: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700; color: #151515;'>{$user.email}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; color: #151515;' valign='top'>Telefon: <span style='vertical-align: top; padding: 5px 0 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 700;  color: #151515;'>{$user.phone}</span>
											</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 10px 0px 10px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 700;  color: #151515;' valign='top'>Detalji narudžbe
											</td>
										</tr>
										<tr>
											<td style='vertical-align: top; ' valign='top'>
												<table width='100%' cellpadding='2' cellspacing='2'>
													<tr>
														<th align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle' >Br.</th>
														<th align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle' >Šifra</th>
														<th align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle' >Naziv</th>
														<th align='right' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle' >Cena</th>
														<th align='right' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle' >Kol.</th>
														<th align='right' width='70px' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase; border-top:1px solid #e0e0e0; border-bottom:1px solid #e0e0e0; text-align:right; width:70px;' valign='middle' >Ukupno</th>
													</tr>
													{section name=cnt loop=$orderitems}
													<tr>
														<td align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle'>{$smarty.section.cnt.index+1} </td>
														<td align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle'>{$orderitems[cnt].productcode}</td>
														<td align='left' style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:left;' valign='middle'>{$orderitems[cnt].productname}</td>
														<td align='right'  style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle'>{$orderitems[cnt].price}
															{if $orderitems[cnt].popust neq '0'}
															<br><span style='vertical-align: middle; padding: 5px 0px 5px 0; font-size: 10px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;'>stara cena: {$orderitems[cnt].pricebasic}</span>
															<br><span style='vertical-align: middle; padding: 5px 0px 5px 0; font-size: 10px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase;'>{$orderitems[cnt].popustopis}: {$orderitems[cnt].popust}%</span>
															{/if}
														</td>
														<td align='right'  style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle'>{$orderitems[cnt].quantity}</td>
														<td align='right'  style='vertical-align: middle; padding: 5px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 400; line-height: 1.42;  color: #151515; text-transform:uppercase;  border-bottom:1px solid #e0e0e0; text-align:right;' valign='middle'>{$orderitems[cnt].amount} din</td>
													</tr>
													{/section}
												</table>
											</td>
										</tr>

										<tr>
											<td style='vertical-align: top; ' valign='top'>
												<table width='100%' cellpadding='2' cellspacing='2'>
													<tr>
														<td width='60%' style='width:60%;'></td>
														<td width='25%' align='right' style='width:25%; vertical-align: middle; padding: 0px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase;   text-align:right;' valign='middle'>Ukupno: </td>
														<td width='15%' align='right' style='width:15%; vertical-align: middle; padding: 0px 15px 5px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 12px; font-weight: 700; line-height: 1.42;  color: #151515; text-transform:uppercase;   text-align:right;' valign='middle'>{$ukupna_cena} din</td>
													</tr>
												</table>
											</td>
										</tr>

										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 10px 0 20px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; color: #151515;' valign='top'>Napomena: <span style='vertical-align: top; padding: 10px 0 20px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 1.89;  color: #151515;'>{$note}</span></td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 30px 15px 10px 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 24px; font-weight: 700;  color: #151515; border-bottom:1px solid #e0e0e0;' valign='top'>Slanje za: {$shipping.name} {$shipping.surname}</td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 10px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; color: #151515;' valign='top'>Adresa: <span style='vertical-align: top; padding: 10px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 700; color: #151515;'>{$shipping.address}</span></td>
										</tr>

										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400;  color: #151515;' valign='top'>Poštanski broj: <span style='vertical-align: top; padding: 5px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 700;   color: #151515;'>{$shipping.postalcode}</span></td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400;  color: #151515;' valign='top'>Grad: <span style='vertical-align: top; padding: 5px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 700; color: #151515;'>{$shipping.place}</span></td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; color: #151515;' valign='top'>Telefon: <span style='vertical-align: top; padding: 5px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 700;  color: #151515;'>{$shipping.phone}</span></td>
										</tr>
										<tr>
											<td class='pc-fb-font' style='vertical-align: top; padding: 5px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; color: #151515;' valign='top'>E-mail: <span style='vertical-align: top; padding: 5px 0 0 0; font-family: Fira Sans, Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 700;  color: #151515;'>{$shipping.email}</span></td>
										</tr>
									</tbody>
								</table>
							</td>
						</tr>
					</tbody>
				</table>
			</td>
		</tr>
	</tbody>
</table>

				   <!-- END MODULE: Call to action 5 -->
