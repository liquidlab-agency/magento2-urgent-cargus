<?php
/**
 * Created by PHPStorm
 * User: Alexandru Marinescu
 * Date: 16.05.2022
 * Copyright: Tremend Software Consulting
 */
declare(strict_types=1);

namespace Urgent\CargusOldAwb\Api\Data;

/**
 * Old Awb Interface
 *
 * Description: Is not used to full only for view info from old table.
 */
interface OldAwbInterface
{
    public const TABLE_NAME = 'awb_expeditii';

    public const ID = 'id';
    public const ORDER_ID = 'order_id';
    public const PICKUP_LOCATION_ID = 'pickup_location_id';
    public const COD_BARA = 'cod_bara';
    public const TIMESTAMP = 'timestamp';
    public const NUME_DEST = 'nume_dest';
    public const JUDET_ID = 'judet_id';
    public const JUDET_DEST = 'judet_dest';
    public const LOCALITATE_ID = 'localitate_id';
    public const LOCALITATE_DEST = 'localitate_dest';
    public const ADRESA_DEST = 'adresa_dest';
    public const CONTACT_DEST = 'contact_dest';
    public const TELEFON_DEST = 'telefon_dest';
    public const EMAIL_DEST = 'email_dest';
    public const COD_POSTAL = 'cod_postal';
    public const PLICURI = 'plicuri';
    public const COLETE = 'colete';
    public const KILOGRAME = 'kilograme';
    public const LUNGIME = 'lungime';
    public const LATIME = 'latime';
    public const INALTIME = 'inaltime';
    public const VALOARE_DECLARATA = 'valoare_declarata';
    public const RAMBURS_NUMERAR = 'ramburs_numerar';
    public const RAMBURS_CONT = 'ramburs_cont';
    public const RAMBURS_ALT = 'ramburs_alt';
    public const PLATITOR_EXPEDITIE = 'platitor_expeditie';
    public const LIVRARE_SAMBATA = 'livrare_sambata';
    public const LIVRARE_DIMINEATA = 'livrare_dimineata';
    public const DESCHIDERE_COLET = 'deschidere_colet';
    public const OBSERVATII = 'observatii';
    public const CONTINUT = 'continut';
    public const STATUS = 'status';
    public const PUDO_ID = 'pudo_id';
}
