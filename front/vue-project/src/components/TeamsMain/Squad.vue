<script>
export default {
  name: 'Squad',
  props: {
    squad: {
      type: Array,
      default: () => []
    },
    color: {
      type: String,
      default: '#ffffff'
    }
  },
  data() {
    return {
      bench: [],          // игроки вне поля
      startingXI: [],     // игроки на поле (максимум 5)
      draggingPlayer: null
    }
  },
  computed: {
    // сортируем таблицу по номеру
    sortedBench() {
      return [...this.bench].sort((a, b) => a.number - b.number)
    },
    // средний рейтинг игроков на поле
    averageFieldRate() {
      if (this.startingXI.length === 0) return 0
      const sum = this.startingXI.reduce((acc, p) => acc + (p.rate || 0), 0)
      return (sum / this.startingXI.length).toFixed(1)
    },
    // контрастный цвет для номера на футболке
    shirtTextColor() {
      const hex = this.color.replace('#', '')
      const r = parseInt(hex.substr(0, 2), 16)
      const g = parseInt(hex.substr(2, 2), 16)
      const b = parseInt(hex.substr(4, 2), 16)
      const brightness = (r * 299 + g * 587 + b * 114) / 1000
      return brightness > 128 ? '#000000' : '#FFFFFF'
    }
  },
  created() {
    // изначально все игроки приходят в составе и считаются "на скамейке"
    this.bench = [...this.squad]
  },
  methods: {
    onDragStart(player) {
      this.draggingPlayer = player
    },
    allowDrop(event) {
      event.preventDefault()
    },
    // дроп в основное поле
    onDropToStarting(event) {
      event.preventDefault()
      if (!this.draggingPlayer) return

      // ограничение максимум 5 игроков
      if (this.startingXI.length >= 5) {
        alert('В основе может быть максимум 5 игроков')
        this.draggingPlayer = null
        return
      }

      // не добавляем дубликаты
      if (this.startingXI.find(p => p.id === this.draggingPlayer.id)) {
        this.draggingPlayer = null
        return
      }

      this.bench = this.bench.filter(p => p.id !== this.draggingPlayer.id)
      this.startingXI.push(this.draggingPlayer)
      this.draggingPlayer = null
    },
    // дроп обратно на скамейку
    onDropToBench(event) {
      event.preventDefault()
      if (!this.draggingPlayer) return

      if (this.bench.find(p => p.id === this.draggingPlayer.id)) {
        this.draggingPlayer = null
        return
      }

      this.startingXI = this.startingXI.filter(p => p.id !== this.draggingPlayer.id)
      this.bench.push(this.draggingPlayer)
      this.draggingPlayer = null
    }
  }
}
</script>

<template>
  <div class="squad-layout">
    <!-- Таблица всех игроков команды (скамейка) -->
    <div class="bench">
      <h2>Состав команды</h2>
      <table class="players-table">
        <thead>
          <tr>
            <th>#</th>
            <th>Игрок</th>
            <th>Номер</th>
            <th>Рейтинг</th>
          </tr>
        </thead>
        <tbody>
          <tr
            v-for="(player, index) in sortedBench"
            :key="player.id"
            draggable="true"
            @dragstart="onDragStart(player)"
          >
            <td class="position-cell">
              {{ index + 1 }}
            </td>
            <td>{{ player.name }}</td>
            <td>{{ player.number }}</td>
            <td>{{ player.rate }}</td>
          </tr>
        </tbody>
      </table>
    </div>

    <!-- Поле с основным составом -->
    <div
      class="field"
      @dragover="allowDrop"
      @drop="onDropToStarting"
    >
      <h2>
        Основной состав (до 5)
        <span v-if="startingXI.length">
          — ср. рейтинг: {{ averageFieldRate }}
        </span>
      </h2>

      <div class="field-players">
        <div
          v-for="player in startingXI"
          :key="player.id"
          class="shirt"
          draggable="true"
          @dragstart="onDragStart(player)"
        >
          <div
            class="shirt-body"
            :style="{ backgroundColor: color }"
          >
            <div
              class="shirt-number"
              :style="{ color: shirtTextColor }"
            >
              {{ player.number }}
            </div>
          </div>
          <div class="shirt-name">{{ player.name }}</div>
        </div>
      </div>
    </div>

    <!-- Зона для возврата игрока на скамейку -->
    <div
      class="bench-dropzone"
      @dragover="allowDrop"
      @drop="onDropToBench"
    >
      Перетащи сюда игрока, чтобы вернуть его на скамейку
    </div>
  </div>
</template>

<style scoped>
.squad-layout {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

/* таблица */

.bench {
  background: #fff;
  padding: 16px;
  border-radius: 4px;
}

.players-table {
  width: 100%;
  border-collapse: collapse;
}

.players-table th,
.players-table td {
  border: 1px solid #ccc;
  padding: 8px 10px;
  text-align: left;
}

.players-table thead {
  background-color: #f3f3f3;
}

.position-cell {
  font-weight: 600;
}

/* поле */

.field {
  background: linear-gradient(#3c9952, #2e7b40);
  padding: 16px;
  border-radius: 8px;
  min-height: 220px;
  color: #fff;
}

.field h2 {
  margin: 0;
}

.field-players {
  display: flex;
  flex-wrap: wrap;
  gap: 16px;
  margin-top: 12px;
}

/* футболка */

.shirt {
  display: flex;
  flex-direction: column;
  align-items: center;
  cursor: grab;
}

.shirt-body {
  position: relative;
  width: 60px;
  height: 70px;
  border-radius: 8px 8px 10px 10px;
  box-shadow: 0 0 4px rgba(0, 0, 0, 0.4);
}

/* рукава */
.shirt-body::before,
.shirt-body::after {
  content: '';
  position: absolute;
  top: 8px;
  width: 20px;
  height: 24px;
  background: inherit; /* тот же цвет, что у футболки */
}

.shirt-body::before {
  left: -18px;
  border-radius: 8px 0 8px 8px;
}

.shirt-body::after {
  right: -18px;
  border-radius: 0 8px 8px 8px;
}

.shirt-number {
  position: absolute;
  bottom: 8px;
  left: 50%;
  transform: translateX(-50%);
  font-weight: 700;
  font-size: 20px;
}

.shirt-name {
  margin-top: 4px;
  font-size: 12px;
  text-align: center;
  max-width: 90px;
}

/* зона возврата */

.bench-dropzone {
  margin-top: 10px;
  padding: 10px;
  border: 2px dashed #aaa;
  text-align: center;
  font-size: 14px;
  border-radius: 4px;
  background: #fafafa;
}
</style>
