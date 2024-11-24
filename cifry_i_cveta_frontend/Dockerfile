# Stage 1: Build the application
FROM dockerhub.timeweb.cloud/node:22 AS build

# Set the working directory
WORKDIR /app

# Copy package.json and package-lock.json
COPY package*.json ./

# Install dependencies
RUN npm install

# Copy the rest of the application code
COPY . .

# Build the application
RUN npm run build


# Use a lightweight Nginx image as the final base image
FROM dockerhub.timeweb.cloud/nginx:alpine

# Copy the built app from the build stage to the NGINX HTML directory
COPY --from=build /app/dist /usr/share/nginx/html
COPY nginx.conf /etc/nginx/conf.d/default.conf

ENV TZ=Europe/Moscow

# Expose port 80
EXPOSE 80

# Command to start Nginx when the container starts
CMD ["nginx", "-g", "daemon off;"]