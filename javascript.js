// FUNCTION FOR HAMBURGER MENU
function MENUBAR(){
	const menu = document.getElementById("menulist");
	menu.classList.toggle("open");
}

//DISPLAYING ALL THE INFORMATION FROM THE ARRAY IN THE PRODUCTS PAGE AND A BUTTON 
if (window.location.pathname.includes("products.php")) {
	
	let len = tshirts.length;

	for (let i = 0; i < len; i++) {
		let item = document.createElement("div");
		item.className = "shirts";
		
		item.setAttribute("stock", tshirts[i].product_stock);
		
		//IMAGE 
		let img = document.createElement("img");
		img.src = tshirts[i].product_src;
    
		//TSHIRT
		let name = document.createElement("h3");
		name.textContent = tshirts[i].product_title;
		
		//PRICE
		let price = document.createElement("p");
		price.className = "prices";
		price.textContent = tshirts[i].product_price;

		//DESCRIPTION
		let desc = document.createElement("p");
		desc.textContent = tshirts[i].product_desc;
		
		//BUY BUTTON
		let buyButton = document.createElement("button");
		buyButton.textContent = "Buy";
		
		//AVAILABILITY LABEL (FOR OUT OF STOCK ONLY)
		let avail = document.createElement("p");
		avail.className = "availability";
		
		//READ MORE BUTTON + SAVES THE DATA WITH SESSION STORAGE + REDIRECTS IF PRESSED TO ITEM.HTML
		let lm = document.createElement("button");
		lm.textContent = "Read More";
		lm.addEventListener("click", () => {
			const id = tshirts[i].product_id;
			window.location.href="item.php?id=" +id;
		});	
		
		if(!isLoggedIn){
			buyButton.addEventListener("click",()=>{
				alert("In order to purchase items you need to be logged in!");
				window.location.href="register.php";
			});
			
			lm.addEventListener("click",()=>{
				alert("In order to view items you need to be logged in!");
				window.location.href="register.php";
			});
		}
		
		else{
			//BUY BUTTON ALERT MESSAGE + SAVES ITEMS TO CART IF STOCK IS AVAILABLE
			if(tshirts[i].product_stock==="good-stock" || tshirts[i].product_stock ==="low-stock"){
			buyButton.addEventListener("click" , function(){
			let cart = JSON.parse(localStorage.getItem("cart")) || [];
			//USES CART.PUSH TO SAVE INFORMATION USING LOCAL STORAGE
			cart.push({
				name:tshirts[i].product_title,
				price:tshirts[i].product_price,
				img:tshirts[i].product_src
			});
			//SAVES THE INFORMATION AS STRINGS
			localStorage.setItem("cart",JSON.stringify(cart));
			alert("Added to Cart");
			});
			}
			//IF NO STOCK IS AVAILABLE DISPLAY APPROPRIATE MESSAGE
			else{
				buyButton.addEventListener("click" , function(){
				alert("Sorry , We are out of stock");
			});
			}
		}
	//APPENDS EACH ELEMENT FOR DISPLAY AT PRODUCTS PAGE
    item.appendChild(img);
	//CHECKS IF AN ITEM IS OUT OF STOCK DISPLAYS THE LABEL AVAIL
	if(tshirts[i].product_stock == "out-of-stock"){
		avail.textContent = " OUT OF STOCK " ;
		item.appendChild(avail);
	}
    item.appendChild(name);
    item.appendChild(price);
    item.appendChild(desc);
	item.appendChild(buyButton);
	item.appendChild(lm);
    document.getElementById("products").appendChild(item);
}

//GETS THE DROPDOWN ELEMENT FROM THE PRODUCT PAGE
const Select = document.getElementById("filter");
if(Select){
//GETS ALL TSHIRTS WITH CLASSNAME "shirts"
const Products = document.querySelectorAll(".shirts");

	//REACTS TO WHEN THE VALUE FROM THE DROPDOWN ELEMENT CHANGES IN PRODUCTS PAGE
    Select.addEventListener("change", (e) => {
		//GETS THE VALUE OF WHATS BEEN SELECTED FROM THE DROPDOWN ELEMENT FROM THE PRODUCTS PAGE
        const filter = e.target.value;
		//GOES THROUGH ALL TSHIRTS
        Products.forEach(product => {
			//GETS THE AVAILABILITY FROM THE ARRAY OF EACH TSHIRT
            const stock = product.getAttribute("stock");
			//IF THE DROPDOWN ELEMENT HAS "ALL" SELECTED OR IF IT HAS ANY MATCHES FROM ANY TSHIRTS AVAILABILTY DISPLAY THE TSHIRT WITH THAT SPECIFIC AVAILABILITY 
            if (filter == "all" || stock == filter) {
                product.style.display = ""; 
			//IF IT DOES NOT MATCH HIDE THE TSHIRT	
            } else {
                product.style.display = "none"; 
            }
        });
    });
}
else{
	console.log("ERROR OCCURED");
}
}


//ONLY EXECUTE WHEN IN CART.HTML
if (window.location.pathname.includes("cart.php")){
	//GETS CONTAINER WHERE INFORMATION WILL BE DISPLAYED
	const cart = document.getElementById("cart");
	
	//GET ITEMS FROM LOCAL STORAGE
	let c = JSON.parse(localStorage.getItem("cart"));
	
	//LOOP THROUGH ALL ITEMS
	for(let i=0 ; i<c.length ; i++){
		
		const item = c[i];

		//CREATE A DIVISION ELEMENT
		let division = document.createElement("div");
		division.className ="cartdiv";
		
		//CREATE NAME ELEMENT
		let name = document.createElement("h3");
		name.textContent = item.name;
		
		//CREATE IMAGE ELEMENT
		let img = document.createElement("img");
		img.className = "cartimg";
		img.src = item.img;
		
		//CREATE COLOR ELEMENT
		let color = document.createElement("p");
		color.textContent = item.color;
		
		//CREATE PRICE ELEMENT
		let price = document.createElement("p");
		price.className = "prices";
		price.textContent = item.price;
		
		//APPEND ALL ELEMENTS
		
		division.appendChild(name);
		division.appendChild(img);
		division.appendChild(color);
		division.appendChild(price);

		cart.appendChild(division);
	}	
}