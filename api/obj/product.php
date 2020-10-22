<?php


/**
 * readOneProduct
 */
class Products
{

	public $conn;

	public $color, $hash,  $date, $description, $dateCreated, $dateModified, $productId, $featureId, $colorId;

	public $image, $docsId, $accountId, $status, $caption, $categoryId, $name, $price, $tittle, $specificationCategory;

	public $pct_tittle, $pct_description, $salt, $computed_hash, $sc_tittle , $sc_description;

	public $cp_status, $p_id, $cp_dateCreated, $reference, $s_category;
	
	function __construct($db)
	{
		$this->conn = $db;

	}// end of the constructor
	
	function createProductFeatures(){

		$query = 'INSERT INTO features
					SET 
						f_image=:f_image,
						f_tittle=:f_tittle,
						f_description=:f_description,
						f_created=:f_created,
						f_modified=:f_modified,
						p_id=:p_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->image = htmlspecialchars(strip_tags($this->image));
		$this->tittle = htmlspecialchars(strip_tags($this->tittle));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
		$this->dateModified = htmlspecialchars(strip_tags($this->dateModified));
		$this->productId = htmlspecialchars(strip_tags($this->productId));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':f_image', $this->image);
		$stmt->bindParam(':f_tittle', $this->tittle);
		$stmt->bindParam(':f_description', $this->description);
		$stmt->bindParam(':f_created', $this->dateCreated);
		$stmt->bindParam(':f_modified', $this->dateModified);
		$stmt->bindParam(':p_id', $this->productId);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function createProduct(){

		$query = 'INSERT INTO product
					SET 
						p_Imagelook=:p_Imagelook,
						p_name=:p_name,
						p_caption=:p_caption,
						p_price=:p_price,
						p_description=:p_description,
						p_datecreated=:p_datecreated,
						p_datemodified=:p_datemodified,
						pct_id=:pct_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->image = htmlspecialchars(strip_tags($this->image));
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->caption = htmlspecialchars(strip_tags($this->caption));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
		$this->dateModified = htmlspecialchars(strip_tags($this->dateModified));
		$this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':p_Imagelook', $this->image);
		$stmt->bindParam(':p_name', $this->name);
		$stmt->bindParam(':p_caption', $this->caption);
		$stmt->bindParam(':p_price', $this->price);
		$stmt->bindParam(':p_description', $this->description);
		$stmt->bindParam(':p_datecreated', $this->dateCreated);
		$stmt->bindParam(':p_datemodified', $this->dateModified);
		$stmt->bindParam(':pct_id', $this->categoryId);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function createProductCategoryType(){

		$query = 'INSERT INTO product_category_type 
					SET  
						pct_tittle=:pct_tittle,
						pct_description=:pct_description';

		$stmt = $this->conn->prepare($query);

		$this->pct_tittle = htmlspecialchars(strip_tags($this->pct_tittle));
		$this->pct_description = htmlspecialchars(strip_tags($this->pct_description));
		
		$stmt->bindParam(':pct_tittle', $this->pct_tittle);
		$stmt->bindParam(':pct_description', $this->pct_description);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function create_createdProduct(){

		$query = 'INSERT INTO created_product 
					SET  
						cp_status=:cp_status,
						p_id=:p_id,
						f_id=:f_id,
						cp_dateCreated=:cp_dateCreated,
						c_id=:c_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->status = htmlspecialchars(strip_tags($this->status));
		$this->productId = htmlspecialchars(strip_tags($this->productId));
		$this->featureId = htmlspecialchars(strip_tags($this->featureId));
		$this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
		$this->colorId = htmlspecialchars(strip_tags($this->colorId));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':cp_status', $this->status);
		$stmt->bindParam(':p_id', $this->productId);
		$stmt->bindParam(':f_id', $this->featureId);
		$stmt->bindParam(':cp_dateCreated', $this->dateCreated);
		$stmt->bindParam(':c_id', $this->colorId);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function create_specification(){

		$query = 'INSERT INTO specification 
					SET  
						s_specification_type=:s_specification_type,
						s_description=:s_description,
						s_category=:s_category,
						p_id=:p_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->tittle = htmlspecialchars(strip_tags($this->tittle));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->specificationCategory = htmlspecialchars(strip_tags($this->specificationCategory));
		$this->productId = htmlspecialchars(strip_tags($this->productId));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':s_specification_type', $this->tittle);
		$stmt->bindParam(':s_description', $this->description);
		$stmt->bindParam(':s_category', $this->specificationCategory);
		$stmt->bindParam(':p_id', $this->productId);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function create_services(){

		$query = 'INSERT INTO service 
					SET  
						service_type_tittle=:service_type_tittle,
						service_description=:service_description,
						service_date_created=:service_date_created,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->tittle = htmlspecialchars(strip_tags($this->tittle));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':service_type_tittle', $this->tittle);
		$stmt->bindParam(':service_description', $this->description);
		$stmt->bindParam(':service_date_created', $this->dateCreated);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function readAllProductCategory(){

		$query = 'SELECT
						*
					FROM product_category_type';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function created_product(){

		$query = 'INSERT INTO created_product 
					SET  
						cp_status=:cp_status,
						p_id=:p_id,
						cp_dateCreated=:cp_dateCreated';

		$stmt = $this->conn->prepare($query);

		$this->cp_status = htmlspecialchars(strip_tags($this->cp_status));
		$this->p_id = htmlspecialchars(strip_tags($this->p_id));
		$this->cp_dateCreated = htmlspecialchars(strip_tags($this->cp_dateCreated));

		$stmt->bindParam(':cp_status', $this->cp_status);
		$stmt->bindParam(':p_id', $this->p_id);
		$stmt->bindParam(':cp_dateCreated', $this->cp_dateCreated);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function

	function readOneProduct(){

		$query = '	SELECT 
						*
					FROM product
					WHERE 
						computed_hash = ?
					LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(1, $this->hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function updateCreatedProductStatus(){

		$query = ' UPDATE created_product, product
            		SET
	                	created_product.cp_status =:cp_status
            		WHERE
               	 		(product.p_id = created_product.p_id) AND created_product.p_id = :p_id';

		$stmt = $this->conn->prepare($query);

		$this->p_id = htmlspecialchars(strip_tags($this->p_id));
		$this->cp_status = htmlspecialchars(strip_tags($this->cp_status));
		
		$stmt->bindParam(':p_id', $this->p_id);
		$stmt->bindParam(':cp_status', $this->cp_status);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function

	function readAllPublishProducts(){

		$query = 'SELECT 
						product.p_id as productid,
						product.p_name as productname,
						product.p_datecreated as productdate,
						product.computed_hash as producthash,
						product.p_Imagelook as productImage,
						product.salt as productsalt,
						created_product.cp_id as createdproductid
                        
					FROM product, created_product
					WHERE 
						((created_product.cp_status = "publish") and (created_product.p_id = product.p_id))
						GROUP BY product.p_name, product.p_datecreated, product.computed_hash, created_product.cp_status';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function



	function readAllPendingProducts(){

		$query = 'SELECT 
						product.p_name as productname,
						product.p_datecreated as productdate,
						product.computed_hash as producthash,
						product.p_Imagelook as productImage,
						product.salt as productsalt

					FROM product, created_product
					WHERE 
						((created_product.cp_status = "pending") and (created_product.p_id = product.p_id))
						GROUP BY product.p_name, product.p_datecreated, product.computed_hash, created_product.cp_status';

		$stmt = $this->conn->prepare($query);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function editProduct(){

		$query = ' UPDATE product
            		SET
	                	p_Imagelook=:p_Imagelook,
						p_name=:p_name,
						p_caption=:p_caption,
						p_price=:p_price,
						p_description=:p_description,
						p_datecreated=:p_datecreated,
						p_datemodified=:p_datemodified,
						pct_id=:pct_id,
						salt=:salt,
						computed_hash=:computed_hash
					WHERE computed_hash=:reference ';

		$stmt = $this->conn->prepare($query);

		$this->image = htmlspecialchars(strip_tags($this->image));
		$this->name = htmlspecialchars(strip_tags($this->name));
		$this->caption = htmlspecialchars(strip_tags($this->caption));
		$this->price = htmlspecialchars(strip_tags($this->price));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->dateCreated = htmlspecialchars(strip_tags($this->dateCreated));
		$this->dateModified = htmlspecialchars(strip_tags($this->dateModified));
		$this->categoryId = htmlspecialchars(strip_tags($this->categoryId));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));
		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam(':p_Imagelook', $this->image);
		$stmt->bindParam(':p_name', $this->name);
		$stmt->bindParam(':p_caption', $this->caption);
		$stmt->bindParam(':p_price', $this->price);
		$stmt->bindParam(':p_description', $this->description);
		$stmt->bindParam(':p_datecreated', $this->dateCreated);
		$stmt->bindParam(':p_datemodified', $this->dateModified);
		$stmt->bindParam(':pct_id', $this->categoryId);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);
		$stmt->bindParam(':reference', $this->reference);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function


	function readAllFeatures(){

		$query = '	SELECT 
						features.f_id as feature_f_id,
						features.f_image as feature_f_image,
						features.f_tittle as feature_f_tittle,
						features.f_description as feature_f_description,
						features.f_created as feature_f_created,
						features.f_modified as feature_f_modified,
						features.p_id as feature_p_id,
						features.salt as feature_salt,
						features.computed_hash as feature_computed_hash,

						product.p_id as product_pct_id

					FROM features, product
					WHERE 
						(product.p_id = features.p_id) AND features.p_id = ?
					GROUP BY 
						features.f_id,
						features.f_image,
						features.f_tittle,
						features.f_description,
						features.f_created,
						features.f_modified,
						features.p_id,
						features.salt,
						features.computed_hash,
						product.p_id
					';

		$stmt = $this->conn->prepare($query);

		$this->p_id = htmlspecialchars(strip_tags($this->p_id));

		$stmt->bindParam(1, $this->p_id);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function


	function readOneFeature(){

		$query = '	SELECT *
					FROM features
					WHERE 
						computed_hash = ?';

		$stmt = $this->conn->prepare($query);

		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(1, $this->hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function editProductFeature(){

		$query = ' UPDATE features
            		SET
	                	f_image=:f_image,
						f_tittle=:f_tittle,
						f_description=:f_description,
						f_modified=:f_modified,
						salt=:salt,
						computed_hash=:computed_hash
					WHERE computed_hash=:reference ';

		$stmt = $this->conn->prepare($query);

		$this->image = htmlspecialchars(strip_tags($this->image));
		$this->tittle = htmlspecialchars(strip_tags($this->tittle));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->dateModified = htmlspecialchars(strip_tags($this->dateModified));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));
		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam(':f_image', $this->image);
		$stmt->bindParam(':f_tittle', $this->tittle);
		$stmt->bindParam(':f_description', $this->description);
		$stmt->bindParam(':f_modified', $this->dateModified);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);
		$stmt->bindParam(':reference', $this->reference);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function

	function readAllSpecification(){

		$query = 'SELECT 
						specification.s_id as specs_s_id,
						specification.s_specification_type as specs_s_specification_type,
						specification.s_description as specs_s_description,
						specification.s_category as specs_s_category,
						specification.p_id as specs_p_id,
						specification.salt as specs_salt,
						specification.computed_hash as specs_computed_hash
                        
					FROM product, specification
					WHERE 
						((specification.s_category = ?) and (specification.p_id = ?))
					GROUP BY 
						specification.s_id,
						specification.s_specification_type,
						specification.s_description,
						specification.s_category,
						specification.p_id,
						specification.salt,
						specification.computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->s_category = htmlspecialchars(strip_tags($this->s_category));
		$this->p_id = htmlspecialchars(strip_tags($this->p_id));

		$stmt->bindParam(1, $this->s_category); 
		$stmt->bindParam(2, $this->p_id);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function editSpecification(){

		$query = ' UPDATE specification
            		SET
	                	s_specification_type=:s_specification_type,
						s_description=:s_description,
						s_category=:s_category,
						salt=:salt,
						computed_hash=:computed_hash
					WHERE computed_hash=:reference ';

		$stmt = $this->conn->prepare($query);

		$this->tittle = htmlspecialchars(strip_tags($this->tittle));
		$this->description = htmlspecialchars(strip_tags($this->description));
		$this->specificationCategory = htmlspecialchars(strip_tags($this->specificationCategory));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));
		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam(':s_specification_type', $this->tittle);
		$stmt->bindParam(':s_description', $this->description);
		$stmt->bindParam(':s_category', $this->specificationCategory);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);
		$stmt->bindParam(':reference', $this->reference);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function

	function readOneSpecification(){

		$query = '	SELECT *
					FROM specification
					WHERE 
						computed_hash = ?';

		$stmt = $this->conn->prepare($query);

		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(1, $this->hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function
 
	function createColors(){

		$query = 'INSERT INTO colors
					SET 
						c_name=:c_name,
						p_id=:p_id,
						salt=:salt,
						computed_hash=:computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->color = htmlspecialchars(strip_tags($this->color));
		$this->p_id = htmlspecialchars(strip_tags($this->p_id));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(':c_name', $this->color);
		$stmt->bindParam(':p_id', $this->p_id);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// end of the function


	function readAllColors(){

		$query = 'SELECT 
						colors.c_id as color_c_id,
						colors.c_name as color_c_name,
						colors.p_id as color_p_id,
						colors.salt as color_salt,
						colors.computed_hash as color_computed_hash
                        
					FROM product, colors
					WHERE 
						(colors.p_id = ?)
					GROUP BY 
						colors.c_id,
						colors.c_name,
						colors.p_id,
						colors.salt,
						colors.computed_hash';

		$stmt = $this->conn->prepare($query);

		$this->p_id = htmlspecialchars(strip_tags($this->p_id));

		$stmt->bindParam(1, $this->p_id);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function readOneColor(){

		$query = '	SELECT *
					FROM colors
					WHERE 
						computed_hash = ?
					LIMIT 0,1';

		$stmt = $this->conn->prepare($query);

		$this->hash = htmlspecialchars(strip_tags($this->hash));

		$stmt->bindParam(1, $this->hash);

		if($stmt->execute()){

			return $stmt;

		}else{

			return false;
			
		}

	}// end of the function

	function editColor(){

		$query = ' UPDATE colors
            		SET
	                	c_name=:c_name,
						salt=:salt,
						computed_hash=:computed_hash
						
					WHERE computed_hash=:reference ';

		$stmt = $this->conn->prepare($query);

		$this->color = htmlspecialchars(strip_tags($this->color));
		$this->salt = htmlspecialchars(strip_tags($this->salt));
		$this->hash = htmlspecialchars(strip_tags($this->hash));
		$this->reference = htmlspecialchars(strip_tags($this->reference));

		$stmt->bindParam(':c_name', $this->color);
		$stmt->bindParam(':salt', $this->salt);
		$stmt->bindParam(':computed_hash', $this->hash);
		$stmt->bindParam(':reference', $this->reference);

		if($stmt->execute()){

			return true;

		}else{

			return false;

		}

	}// ene of the function


	


}