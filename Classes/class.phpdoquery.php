<?php
/************
Classe phpdoquery
Author: stefano Pascazi
Author uri: http://www.stefanopascazi.it
Version: 1.0.0 beta
Report and BUG: http://stefanopascazi.it
*************/

// includo il file di configurazione per il database
include_once 'config.php';
/*
Il file config.php contiene una classe chiamata DBconn() che viene richiamata dal costruttore della classe phpdoquery in maniera automatica ogni qualvolta si istanzia un nuovo oggetto
*/
/*********************************************************************************************************/
/********************************** MODALITA DI UTILIZZO DELLA CLASSE ************************************/
/*********************************************************************************************************/
/*
PER RICHIAMARE LA CLASSE ED ISTANZIARE UNO OGGETTO:
$oggetto = new phpdoquery();

PER DISTRUGGERE L'OGGETTO CREATO:
unset( $oggetto );

VARIABILI
SONO PRESENTI OTTO VARIABILI A CUI POSSIAMO ASSEGNARE UN VALORE
$oggetto->table = NOME DELLA TABELLA
$oggetto->order = ORDINAMENTO DELLA TBELLA ESEMPIO id DESC ( PUO ESSERE LASCIATO NULLO )
$oggetto->limit = IL LIMIT DELLA TABELLA. ESEMPIO 0,10 ( PUO ESSERE LASCIATO NULLO )
$oggetto->insert = RICEVE UN ARRAY ASSOCIATIVO. ESEMPIO: array( 'nome_campo' => 'valore' )
$oggetto->where = RICEVE UN ARRAY ASSOCIATIVO. ESEMPIO: array('nome_campo' => 'valore')
$oggetto->set = RICEVE UN ARRAY ASSOCIATIVO. ESEMPIO: array('nome_campo' => 'valore')
$oggetto->per_page = VA PASSATO UN NUMERO PER LA PAGINAZIONE
$oggetto->page = VAPASSATO UN NUMERO PER LA PAGINAZIONE

Esempio:
$oggetto->table = 'post';

FUNZIONI
TUTTE QUESTE FUNZIONI RESTITUISCONO IN VALORE IN VARIABILE $result
$oggetto->DoQuery(); esegue una SELECT
$oggetto->FreeQuery(); esegue una qualsiasi Query scritta a nostro modo passata in variabile. ESEMPIO: FreeQuery( $var );
$oggetto->DoUpdate(); esegue un UPDATE
$oggetto->DoInsert(); esegue un INSERT INTO
$oggetto->DoDelete(); esegue un DELETE su una tabella
$oggetto->SingleQuery(); esegue una query SELECT specifica per un risultato. Ritorna valore in variabile $row

I loro debug:
$oggetto->Debug_DoQuery();
$oggetto->Debug_DoInsert();
$oggetto->Debug_DoUpdate();
$oggetto->Debug_DoDelete();
$oggetto->Debug_SingleQuery();
$oggetto->Debug_FreeQuery();

FUNZIONI DI STAMPA RISULTATI

$oggetto->Rows() esegue un mysqli_fecth_object
$oggetto->ArrayRows() esegue un mysqli_fetch_array
$oggetto->CountNumRows() esegue un mysqli_num_rows

FUNZIONI PER PAGINAZIONE

$oggetto->CountRows() esegue una query SELECT e restituisce la conta delle righe della tabella
$oggetto->AllPage() Crea il numero delle pagine in base al parametro $oggetto->per_page
$oggetto->First() Trova l'occorrenza della prima pagina

PULSANTI PER PAGINAZIONE
$oggetto->next_page() crea il tasto pagina successiva
$oggetto->prev_page() crea il tasto pagina precedente
ENTRAMBI I CASI ACCETTANO UN ARRAY ASSOCIATIVO. ESEMPIO
$param = array(
               'field' => 'nome_campo',
			   'order' => 'ordinamento',
			   'title_next' => 'pagina successiva',
			   'title_prev' => 'pagina precedente'
			   )
$oggetto->next_page( $param ) oppure $oggetto->prev_page( $param )
QUESTO CI PERMETTE DI CREARE NON SOLO UNA PAGINAZIONE MA ABBIAMO LA POSSIBILITà DI FILTRARE I NOSTRI RISULTATI

PULSANTI PER PAGINAZIONE COMPLETA
$oggetto->Pagination() estrae una vera e propria paginazione. esempio << 1 2 3 4 5 >>
Anche la funzione Pagination() accetta un parametro array associativo:
$param = array(
               'field' => 'nome_campo',
			   'order' => 'ordinamento'
			   )
$oggetto->Pagination( $param )

FACCIAMO UN ESEMPIO DI UNA QUERY SELECT CON WHERE, ORDINAMENTO E LIMIT

$oggetto = new phpdoquery();
$oggetto->table = 'post';
$oggetto->where = array(
                        'category' => 10,
						'public' => 1
						);
$oggetto->limit = '0,10';
$oggetto->order = 'id DESC';
$result= DoQuery();
if( !$result == NULL ) :
	while ( $row = $oggetto->Rows( $result ) ) :
		echo $row->name;
		echo $row->surname;
	endwhile;
else :
    echo 'OPS! Something is wrong!!';
endif;
*/

/*********************************************************************************************************/
/********************************** CLASSE PER LA GESTIONE DEI DATI NEL DATABASE *************************/
/*********************************************************************************************************/

// creo la classe per la gestione delle query
class phpdoquery {
	// definisco le variabili globali
	
	// definisco se la query è libera
	public $free = '';
	
	// definisce il nome della tabella
	public $table = 'posts';
	
	// definisce l'ordinamento. Esempio id DESC
	public $order = 'id DESC';
	
	// definisce il limit. Esempio 0,10
	public $limit = '';
	
	
	// definisce il distinct. Esempio 'nome_campo'
	public $distinct = '';
	
	// definisce in array sia il field che il value.
	public $insert = '';
	
	// definisce in array sia il field che il value 
	public $where = '';
	
	// definisce in array il set dei valori in update
	public $set = '';
	
	// risultati per pagina
	public $per_page = 10;
	
	//
	public $query = '';
	
	// definisco il costruttore
	private function conn() {
		$conn = new mysqli(HOST, DB_USER, DB_PASSWORD, DB_NAME);
		if( $conn->connect_errno ) {
			echo 'Nessuna connesione al database' . $conn->connect_errno;
			exit();
		} 
		
		return $conn;
	}
		
	public function page() {
		if( !empty( $_GET['pag'] ) ) {
			$pag = $_GET['pag']; // recupero la pagina
		} else {
            $pag = 1; // se non è valorizzato assegno 1 alla pagina
		}
		
		
		return $pag;
		
	}
	
	public function limit() {
		if( $this->per_page ) {
			$limit = $this->First().','.$this->per_page;
			return $limit;
		} else {
			$limit = '';
			return $limit;
		}
	}
	// creo la query
	public function HaveQuery() {
		if( !$this->free ) :
			if( $this->order == '' && $this->limit() == '' && $this->where == '') :
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table;
			elseif( !$this->order == '' && $this->limit() == '' && $this->where == '') :
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." ORDER BY ".$this->order;
			elseif( $this->order == '' && !$this->limit() == '' && $this->where == '' ) :
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." LIMIT ".$this->limit();
			elseif( $this->order == '' && $this->limit() == '' && !$this->where == '' ) :
			
			foreach ( $this->where as $field => $value ) {
				$where = ''; if( $where == '' ) {
					$where .= $field." = '".$value."'";
				} else {
					$where .= " AND ".$field." = '".$value."'";
				}
			}
	
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where;
			elseif( !$this->order == '' && $this->limit() == '' && !$this->where == '' ) :
			
			foreach ( $this->where as $field => $value ) {
				$where = ''; if( $where == '' ) {
					$where .= $field." = '".$value."'";
				} else {
					$where .= " AND ".$field." = '".$value."'";
				}
			}
	
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." ORDER BY ".$this->order;
			elseif( $this->order == '' && !$this->limit() == '' && !$this->where == '' ) :
			
			foreach ( $this->where as $field => $value ) {
				$where = ''; if( $where == '' ) {
					$where .= $field." = '".$value."'";
				} else {
					$where .= " AND ".$field." = '".$value."'";
				}
			}
	
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." LIMIT ".$this->limit();
			elseif( !$this->order == '' && !$this->limit() == '' && $this->where == '' ) :
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." ORDER BY ".$this->order." LIMIT ".$this->limit();
			else :
			
			foreach ( $this->where as $field => $value ) {
				$where = '';
				$where = ''; if( $where == '' ) {
					$where .= $field." = '".$value."'";
				} else {
					$where .= " AND ".$field." = '".$value."'";
				}
			}
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." ORDER BY ".$this->order." LIMIT ".$this->limit();
			endif;
		else :
		    $query = $this->free;
		endif;
		$res = $this->conn()->query( $query );
		if( !empty( $res ) ) : $r = mysqli_fetch_object( $res ); else : $r = ''; endif;
		if( $r == '' ) {
			return FALSE;
		} else {
			return TRUE;
		}
	}
	
	// creo la query
	public function DoQuery() {
		if( !$this->free ) :
			if( $this->order == '' && $this->limit() == '' && $this->where == '') :
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table;
			elseif( !$this->order == '' && $this->limit() == '' && $this->where == '') :
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." ORDER BY ".$this->order;
			elseif( $this->order == '' && !$this->limit() == '' && $this->where == '' ) :
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." LIMIT ".$this->limit();
			elseif( $this->order == '' && $this->limit() == '' && !$this->where == '' ) :
			
			foreach ( $this->where as $field => $value ) {
				$where = ''; if( $where == '' ) {
					$where .= $field." = '".$value."'";
				} else {
					$where .= " AND ".$field." = '".$value."'";
				}
			}
	
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where;
			elseif( !$this->order == '' && $this->limit() == '' && !$this->where == '' ) :
			
			foreach ( $this->where as $field => $value ) {
				$where = ''; if( $where == '' ) {
					$where .= $field." = '".$value."'";
				} else {
					$where .= " AND ".$field." = '".$value."'";
				}
			}
	
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." ORDER BY ".$this->order;
			elseif( $this->order == '' && !$this->limit() == '' && !$this->where == '' ) :
			
			foreach ( $this->where as $field => $value ) {
				$where = ''; if( $where == '' ) {
					$where .= $field." = '".$value."'";
				} else {
					$where .= " AND ".$field." = '".$value."'";
				}
			}
	
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." LIMIT ".$this->limit();
			elseif( !$this->order == '' && !$this->limit() == '' && $this->where == '' ) :
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." ORDER BY ".$this->order." LIMIT ".$this->limit();
			else :
			
			foreach ( $this->where as $field => $value ) {
				$where = ''; if( $where == '' ) {
					$where .= $field." = '".$value."'";
				} else {
					$where .= " AND ".$field." = '".$value."'";
				}
			}
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." ORDER BY ".$this->order." LIMIT ".$this->limit();
			endif;
		else :
		    $query = $this->free;
		endif;
		$result = $this->conn()->query( $query );
		
		return $result;
	}
	
	
	// creo la distinct
	public function DistinctQuery() {
		if( $this->order == '' && $this->limit() == '' && $this->where == '') :
		$query = "SELECT DISTINCT ".$this->distinct." FROM ".TABLE_PREFIX.$this->table;
		elseif( !$this->order == '' && $this->limit() == '' && $this->where == '') :
		$query = "SELECT DISTINCT ".$this->distinct." FROM ".TABLE_PREFIX.$this->table." ORDER BY ".$this->order;
		elseif( $this->order == '' && !$this->limit() == '' && $this->where == '' ) :
		$query = "SELECT DISTINCT ".$this->distinct." FROM ".TABLE_PREFIX.$this->table." LIMIT ".$this->limit();
		elseif( $this->order == '' && $this->limit() == '' && !$this->where == '' ) :
		
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}

		$query = "SELECT DISTINCT ".$this->distinct." FROM ".TABLE_PREFIX.$this->table." WHERE ".$where;
		elseif( !$this->order == '' && $this->limit() == '' && !$this->where == '' ) :
		
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}

		$query = "SELECT DISTINCT ".$this->distinct." FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." ORDER BY ".$this->order;
		elseif( $this->order == '' && !$this->limit() == '' && !$this->where == '' ) :
		
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}

		$query = "SELECT DISTINCT ".$this->distinct." FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." LIMIT ".$this->limit();
		elseif( !$this->order == '' && !$this->limit() == '' && $this->where == '' ) :
		$query = "SELECT DISTINCT ".$this->distinct." FROM ".TABLE_PREFIX.$this->table." ORDER BY ".$this->order." LIMIT ".$this->limit();
		else :
		
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}
		$query = "SELECT DISTINCT ".$this->distinct." FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." ORDER BY ".$this->order." LIMIT ".$this->limit();
		endif;
		$result = $this->conn()->query( $query );
		
		return $result;
	}
	
	// creo la query libera
	public function FreeQuery($query) {
		$result = $this->conn()->query( $query );
		
		return $result;
	}
	
	// creo la query Single
	public function SingleQuery() {
		if( $this->where == '' ) :
		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." ORDER BY id DESC" ;
		else :
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}
		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where;
		endif;
		$result = $this->conn()->query( $query );
		$row = $this->Rows($result);
		
		return $row;
	}	
	
	// Query per l'insert
	public function DoInsert() {
		// estraggo i risultati in array
		foreach ( $this->insert as $field => $value ) {
			if( $fields == '' ) {
				$fields .= "`".$field."`";
			} else {
				$fields .= ", `".$field."`";
			}
			if( $values == '' ) {
				$values .= "'". $this->conn()->real_escape_string($value)."'";
			} else {
				$values .= ", '".$this->conn()->real_escape_string($value)."'";
			}
		}
		$query = "INSERT INTO `".TABLE_PREFIX.$this->table."` (".$fields.") VALUES (".$values." )";
		$result = $this->conn()->query( $query );
		
		return $result;
	}
	
	// Query per l'update 
	public function DoUpdate() {
		// SET è sempre in array, quindi faccio un ciclo foreach
		foreach ( $this->set as $field => $value ) {
			if( $set == '' ) {
				$set .= "`".$field."` = '".$this->conn()->real_escape_string($value)."'";
				} else {
					$set .= ", `".$field."` = '".$this->conn()->real_escape_string($value)."'";
				}
		}
		if( $this->where == '' ) :
		$query = "UPDATE `".TABLE_PREFIX.$this->table."` SET ".$set ;
		else :	
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}
		$query = "UPDATE `".TABLE_PREFIX.$this->table."` SET ".$set." WHERE ".$where;
		endif;
		$result = $this->conn()->query( $query );
		
		return $result;
	}
	
	// Query per il delete
	public function DoDelete() {
		if( $this->where == '' ) :
		echo 'Error, where is empty';
		else : 
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}
		$query = "DELETE FROM `".TABLE_PREFIX.$this->table."` WHERE ".$where;
		endif;
		$result = $this->conn()->query( $query );
		
		return $result;
	}
	
	// Query per join...prima release
	public function DoJoin() {
		$result = $this->conn()->query( $this->query );
		return $result;
	}
	
	public function LastId() {
		$query = "SELECT * FROM " . TABLE_PREFIX . $this->table;
		$this->conn()->query( $query );
		$id = $this->conn()->insert_id();
		
		return $id;
	}
	
	/**********************************************************************************************/
	/********************************* STAMPO TUTTI I POSSIBILI ERRORI ****************************/
	/***************************************** FACCIO I DEBUG *************************************/
	
	// debug di DoQuery
	public function Debug_DoQuery() {
		if( $this->order == '' && $this->limit() == '' && $this->where == '') :
		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table;
		elseif( !$this->order == '' && $this->limit() == '' && $this->where == '') :
		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." ORDER BY ".$this->order;
		elseif( $this->order == '' && !$this->limit() == '' && $this->where == '' ) :
		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." LIMIT ".$this->limit();
		elseif( $this->order == '' && $this->limit() == '' && !$this->where == '' ) :
		
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}

		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where;
		elseif( !$this->order == '' && $this->limit() == '' && !$this->where == '' ) :
		
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}

		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." ORDER BY ".$this->order;
		elseif( $this->order == '' && !$this->limit() == '' && !$this->where == '' ) :
		
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}

		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." LIMIT ".$this->limit();
		elseif( !$this->order == '' && !$this->limit() == '' && $this->where == '' ) :
		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." ORDER BY ".$this->order." LIMIT ".$this->limit();
		else :
		
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}
		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where." ORDER BY ".$this->order." LIMIT ".$this->limit();
		endif;
				
		echo $query;
	}
	
	public function Debug_SingleQuery() {
		if( $this->where == '' ) :
		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table ;
		else :
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}
		$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where;
		endif;
		echo $query;
		exit();
	}
	
	// Debug di FreeQuery
	public function DebugFreeQuery() {
				
		echo $this->free;
		exit();
	}
	
	// Debug per DoInsert
	public function Debug_DoInsert() {
		foreach ( $this->insert as $field => $value ) {
			if( $fields == '' ) {
				$fields .= "`".$field."`";
			} else {
				$fields .= ", `".$field."`";
			}
			if( $values == '' ) {
				$values .= "'".$value."'";
			} else {
				$values .= ", '".$value."'";
			}
		}
		$query = "INSERT INTO `".TABLE_PREFIX.$this->table."` (".$fields.") VALUES (".$values." )";
				
		echo $query;
		exit();
	}
	
	// Debug per DoUpdate
	public function Debug_DoUpdate() {
		foreach ( $this->set as $field => $value ) {
			if( $set == '' ) {
				$set .= "`".$field."` = '".$value."'";
				} else {
					$set .= ", `".$field."` = '".$value."'";
				}
		}
		if( $this->where == '' ) :
		$query = "UPDATE `".TABLE_PREFIX.$this->table."` SET ".$set ;
		else :	
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}
		$query = "UPDATE `".TABLE_PREFIX.$this->table."` SET ".$set." WHERE ".$where;
		endif;
		
		echo $query;
		exit();
	}
	
	//Debug per DoDelete
	public function Debug_DoDelete() {
		if( $this->where == '' ) :
		echo 'Error, where is empty';
		else : 
		foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}
		$query = "DELETE FROM `".TABLE_PREFIX.$this->table."` WHERE ".$where;
		endif;
		
		echo $query;
		exit();
	}
	public function Debug_DoJoin() {
		$query = $this->query;
		echo  $query;
		exit();
	}
	
	/*****************************************************************************************************/
	/******************************************* FUNZIONI ESTRAZIONI PARTICOLARI *************************/
	/*****************************************************************************************************/
	
	
	// fetch_object
	public function Rows($result) {
		$row = $result->fetch_object();
		return $row;
	}
	
	// fetch_object
	public function FetchArray($result) {
		$row = $result->fetch_array();
		return $row;
	}
	
	//num_rows conta quanti risultati ci sono
	public function Count_NumRows() {
		$result = $this->DoQuery();
		$rows = $result->num_rows;
		
		return $rows;
	}
	
	// $row in While con fetch_object
	public function ArrayRows() {
		
		$result = $this->DoQuery();
		$rows = array();
		while( $row = $this->Rows($result) ) {
			$rows[] = $row;
		}
		return $rows;
	}
	/****************************************************************************************************/
	/******************************************* FUNZIONI PER PAGINAZIONE DATI  *************************/
	/****************************************************************************************************/
	
	// Query per paginazione dati
	public function CountRows() {
		if( !$this->query == '' ) :
			$query =  $this->query;
		else :
			if( $this->where == '') :
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table;
			else :
			
			foreach ( $this->where as $field => $value ) {
			$where = ''; if( $where == '' ) {
				$where .= $field." = '".$value."'";
			} else {
				$where .= " AND ".$field." = '".$value."'";
			}
		}
	
			$query = "SELECT * FROM ".TABLE_PREFIX.$this->table." WHERE ".$where;
			endif;
		endif;
		$result = $this->conn()->query( $query );		
		$all_rows = $result->num_rows;
		
		return $all_rows;
	}
	
	// conto le pagine 
	public function AllPage() {
		$all_rows = $this->CountRows();
		$all_page = ceil($all_rows / $this->per_page) ;
		
		return $all_page;
	}
	
	// creo la prima pagina
	public function First() {
		$page = $this->page();
		$first = ( $page - 1 ) * $this->per_page;
		
		return $first;
	}
	
	// Pagina precedente
	public function prev_page( $param ) {
		
		$all_page = $this->AllPage();
		$pag = $this->page();
		if ($all_page > 1){
		  if ($pag > 1){
									  		
			  // estraggo i parametri se ci sono
			  foreach( $param as $name => $value ) {
				  if( $name == 'title_prev' ) {
					  $title = $value;
				  }
			  }
			  if( !$title ) $title = '&laquo;';
			  if( $pag == 1 ) {
				  if( !$_SERVER['QUERY_STRING'] ) {
					  $new_query_string = 'pag=' . ($pag - 1 );
					  
				  } elseif( $_SERVER['QUERY_STRING'] ) {
					  
					  $search = strpos( $_SERVER['QUERY_STRING'], '&pag=' );
					  if( !$search ) {
						  $new_query_string = $_SERVER['QUERY_STRING'] . '&pag=' .($pag - 1 );
					  } else {
						 $new_query_string = str_replace('pag='.$pag , 'pag='.($pag - 1 ), $_SERVER['QUERY_STRING'] );
					  }
					  
				  } else {
					  $new_query_string = str_replace('pag='.$pag , 'pag='.($pag - 1 ), $_SERVER['QUERY_STRING'] );
				  }
			  } else {
				  $new_query_string = str_replace('pag='.$pag , 'pag='.($pag - 1 ), $_SERVER['QUERY_STRING'] );
			  }
				  $url = str_replace( '?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI'] );
				  echo "<li><a href=\"http://" . $_SERVER['SERVER_NAME'] . $url . '?' . $new_query_string . "\">";
				  echo $title."</a></li>";
		  } 
		}
	}
	
	// Pagina precedente
	public function next_page( $param ) {
		
		$all_page = $this->AllPage();
		$pag = $this->page();
		if ($all_page > 1){
		  if ($all_page > $pag){
				  				  		
			  // estraggo i parametri se ci sono
			  foreach( $param as $name => $value ) {
				  if( $name == 'title_next' ) {
					  $title = $value;
				  }
			  }
			  if( !$title ) $title = '&raquo;';
			  if( $pag == 1 && $_SERVER['QUERY_STRING'] == '' ) {
				  $new_query_string = 'pag=' . ($pag + 1 );
				  } elseif( $pag == 1 && $_SERVER['QUERY_STRING'] ) {
					  $check = strpos( $_SERVER['QUERY_STRING'], 'ag=1' ) ;
					  if( $check ) {
						  $new_query_string = str_replace('pag='.$pag , 'pag='.($pag + 1 ), $_SERVER['QUERY_STRING'] );
					  } else {
						  $new_query_string = $_SERVER['QUERY_STRING'] . '&pag=' . ($pag + 1 );
					  }
				  } else {
					  $new_query_string = str_replace('pag='.$pag , 'pag='.($pag + 1 ), $_SERVER['QUERY_STRING'] );
				  }
				  $url = str_replace( '?'.$_SERVER['QUERY_STRING'], '', $_SERVER['REQUEST_URI'] );
				  echo "<li><a href=\"http://" . $_SERVER['SERVER_NAME'] . $url . '?' . $new_query_string . "\">";
				  echo $title."</a></li>";
		  } 
		}
	}
	
	// paginazione a numeri
	public function Pagination( $param ) {
		
		$all_page = $this->AllPage();
		$pag = $this->page;
		
		// prima istanza, se non ho $param
		if( $param == '' ) {
			if ($all_page > 1){
				if ($pag > 1){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?pag=" . ($pag - 1) . "\">";
				  echo "&laquo;</a></li>";
				}
				if ($pag > 3){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?pag=" . ($pag - 3) . "\">";
				  echo ($pag - 3) ."</a></li>";
				}
				if ($pag > 2){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?pag=" . ($pag - 2) . "\">";
				  echo ($pag - 2) ."</a></li>";
				}
				// current page 
				echo '<li class="disabled"><span>'.$pag.'</span></li>';
				// end
				if ($all_page > $pag){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?pag=" . ($pag + 1) . "\">";
				  echo ($pag + 1) . "</a></li>";
				}
				if ($all_page > ($pag +1 )){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?pag=" . ($pag + 2) . "\">";
				  echo ($pag + 2) . "</a></li>";
				}
				if ($all_page > ($pag +2 )){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?pag=" . ($pag + 3) . "\">";
				  echo ($pag + 3) . "</a></li>";
				}
				if ($all_page > $pag){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?pag=" . ($pag + 1) . "\">";
				  echo "&raquo;</a></li>";
				} 
			  }
		} else {
			
			 // estraggo i parametri se ci sono
				  foreach( $param as $name => $value ) {
					  if( $name == 'field' ) {
						  $field = $value;
					  }
					  if( $name == 'order' ) {
						  $order = $value;
					  }
				  }
				 if ($all_page > 1){
				if ($pag > 1){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?field=".$field."&order=".$order."&pag=" . ($pag - 1) . "\">";
				  echo "&laquo;</a></li>";
				}
				if ($pag > 2){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?field=".$field."&order=".$order."&pag=" . ($pag - 2) . "\">";
				  echo ($pag - 2) ."</a></li>";
				}
				
				if ($pag > 1){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?field=".$field."&order=".$order."&pag=" . ($pag - 1) . "\">";
				  echo ($pag - 1) ."</a></li>";
				}
				// current page 
				echo '<li class="disabled"><span>'.$pag.'</span></li>';
				// end
				if ($all_page > ( $pag  ) ){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?field=".$field."&order=".$order."&pag=" . ($pag + 1) . "\">";
				  echo ($pag + 1) . "</a></li>";
				}
				if ($all_page > ( $pag +1 ) ){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?field=".$field."&order=".$order."&pag=" . ($pag + 2) . "\">";
				  echo ($pag + 2) . "</a></li>";
				}
				if ($all_page > ( $pag +2 ) ){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?field=".$field."&order=".$order."&pag=" . ($pag + 3) . "\">";
				  echo ($pag + 3) . "</a></li>";
				}
				if ($all_page > $pag){
				  echo "<li><a href=\"" . dirname($_SERVER['PHP_SELF']) . "?field=".$field."&order=".$order."&pag=" . ($pag + 1) . "\">";
				  echo "&raquo;</a></li>";
				} 
			  } 
		}
	}	
	
}

