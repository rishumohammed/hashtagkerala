import fs from 'fs'
import path from 'path'
import axios from 'axios'

const API_BASE_URL = 'http://localhost/hashtag-kerala/backend/public/api'
const SITE_URL = 'http://localhost:5173'

async function generateSitemap() {
  console.log('Generating sitemap...')
  
  try {
    const districtsResponse = await axios.get(`${API_BASE_URL}/districts`)
    const hotelsResponse = await axios.get(`${API_BASE_URL}/hotels`)
    
    const districts = districtsResponse.data.data || []
    const hotels = hotelsResponse.data.data || []
    
    let xml = `<?xml version="1.0" encoding="UTF-8"?>\n`
    xml += `<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">\n`
    
    // Static pages
    const staticPages = ['', '/']
    staticPages.forEach(page => {
      xml += `  <url>\n    <loc>${SITE_URL}${page}</loc>\n    <priority>1.0</priority>\n  </url>\n`
    })
    
    // District pages
    districts.forEach(dist => {
      xml += `  <url>\n    <loc>${SITE_URL}/districts/${dist.slug}</loc>\n    <priority>0.8</priority>\n  </url>\n`
    })
    
    // Hotel pages (Clean URLs)
    hotels.forEach(hotel => {
      xml += `  <url>\n    <loc>${SITE_URL}/kerala/${hotel.district_slug}/${hotel.slug}</loc>\n    <priority>0.7</priority>\n  </url>\n`
    })
    
    xml += `</urlset>`
    
    const publicPath = path.resolve(process.cwd(), 'public')
    if (!fs.existsSync(publicPath)) {
      fs.mkdirSync(publicPath)
    }
    
    fs.writeFileSync(path.join(publicPath, 'sitemap.xml'), xml)
    console.log(`Sitemap generated successfully at ${path.join(publicPath, 'sitemap.xml')}`)
  } catch (error) {
    console.error('Error generating sitemap:', error.message)
  }
}

generateSitemap()
