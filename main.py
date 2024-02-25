# import streamlit as st
# import pickle

# car=pickle.load(open("car_list.pkl",'rb'))
# similarity=pickle.load(open("similarity.pkl",'rb'))
# car_list=car['Name'].values

# st.header("Car Reparing Shops")
# selectvalue=st.selectbox("Select the Location",car_list)

# def recommend(cars):
#     index=car[car['Name']==cars].index[0]
#     distance=sorted(list(enumerate(similarity[index])), reverse=True,key=lambda vector:vector[1])
#     recommend_car=[]
#     for i in distance[0:5]:
#         recommend_car.append(car.iloc[i[0]].Name)
#     return recommend_car

# if st.button("Recommend"):
#     car_name=recommend(selectvalue)
#     col1,col2,col3,col4,col5=st.columns(5)
#     with col1:
#         st.text(car_name[0])
#     with col2:
#         st.text(car_name[1])
#     with col3:
#         st.text(car_name[2])
#     with col4:
#         st.text(car_name[3])
#     with col5:
#         st.text(car_name[4])
    

# import streamlit as st
# import pickle
# from fuzzywuzzy import process, fuzz

# # Load data and similarity matrix
# car = pickle.load(open("car_list.pkl", "rb"))
# similarity = pickle.load(open("similarity.pkl", "rb"))

# st.header("Car Repair Shops")

# # Input fields for address, pincode, and city
# input_address = st.text_input("Enter Address")
# input_pincode = st.text_input("Enter Pincode")
# input_city = st.text_input("Enter City")

# # Function to recommend car repair shops
# def recommend(address, pincode, city):
#     # Combine address, pincode, and city into a single string
#     input_text = address + pincode + city
    
#     # Define a threshold for fuzzy matching
#     threshold = 70
    
#     # Find similar addresses in the dataset using fuzzy matching
#     similar_addresses = process.extract(input_text, car['tags'], scorer=fuzz.token_sort_ratio)
    
#     # Extract garage names corresponding to similar addresses
#     similar_garages = []
#     for similar_address, score, index in similar_addresses:
#         if score >= threshold:
#             similar_garages.append(car.iloc[index]['Name'])
    
#     return similar_garages

# if st.button("Recommend"):
#     # Recommend car repair shops based on input fields
#     recommended_garages = recommend(input_address, input_pincode, input_city)
    
#     # Display recommended garages
#     if recommended_garages:
#         st.subheader("Recommended Car Repair Shops:")
#         for garage in recommended_garages:
#             st.write(garage)
#     else:
#         st.write("No similar addresses found in the dataset.")


from flask import Flask, render_template, request
import pickle
from fuzzywuzzy import process, fuzz
import pandas as pd

app = Flask(__name__)

# Load data and similarity matrix
car = pickle.load(open("car_list.pkl", "rb"))
similarity = pickle.load(open("similarity.pkl", "rb"))

@app.route('/', methods=['GET', 'POST'])
def index():
    if request.method == 'POST':
        # Get form data
        input_address = request.form['input_address']
        input_pincode = request.form['input_pincode']
        input_city = request.form['input_city']
        
        # Function to recommend car repair shops
        def recommend(address, pincode, city):
            # Combine address, pincode, and city into a single string
            input_text = address + pincode + city
            
            # Define a threshold for fuzzy matching
            threshold = 70
            
            # Find similar addresses in the dataset using fuzzy matching
            similar_addresses = process.extract(input_text, car['tags'], scorer=fuzz.token_sort_ratio)
            
            # Extract garage names corresponding to similar addresses
            similar_garages = []
            for similar_address, score, index in similar_addresses:
                if score >= threshold:
                    similar_garages.append(car.iloc[index]['Name'])
            
            return similar_garages
        
        # Recommend car repair shops based on input fields
        recommended_garages = recommend(input_address, input_pincode, input_city)
        
        # Display recommended garages
        if recommended_garages:
            return render_template('index.html', recommended_garages=recommended_garages)
        else:
            return render_template('index.html', message="No similar addresses found in the dataset.")
    
    return render_template('index.html')

if __name__ == '__main__':
    app.run(debug=True)
